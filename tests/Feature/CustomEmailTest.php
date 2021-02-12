<?php

namespace Tests\Feature;

use App\Mail\SendCustomEmail;
use App\Models\CustomEmail;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CustomEmailTest extends TestCase
{

    use DatabaseMigrations;
    use WithFaker;

    private $headers = [];

     protected function setUp(): void {
         parent::setUp();

        $this->headers =  ['Authorization' => 'Bearer ' . config('app.apiKey') ] ;
     }

    /** @test */
    public function authorisedUserCanSendEmails() {
        Mail::fake();

        $requestBody = [];
        foreach([1,2] as $count) {
          $requestBody['data'][] =  [
                'email' => $this->faker->email,
                'body' => $this->faker->text,
                'subject' => $this->faker->text(20)
            ];
        }

        $this->postJson('/api/send', $requestBody, $this->headers)
            ->assertStatus(Response::HTTP_ACCEPTED);

        $this->assertDatabaseHas('custom_emails', [
            'email' => $requestBody['data'][0]['email'],
            'body' =>  $requestBody['data'][0]['body']
        ])->assertDatabaseHas('custom_emails',  [
            'email' => $requestBody['data'][1]['email'],
            'body' =>  $requestBody['data'][1]['body']
        ]);

        Mail::assertQueued(SendCustomEmail::class, 2);
    }

    /** @test */
    public function authorisedUserCanSendEmailsWithValidAttachments() {
        Mail::fake();

        $name  = $this->faker->lexify('?????');
        $fileName = "{$name}.png";

        $requestBody['data'][] = [
            'email' => $this->faker->email,
            'body' => $this->faker->text,
            'subject' => $this->faker->text(20),
            'attachments' => [ 'name' => $fileName , 'content' => $this->generateBase64String()  ]
        ];

        $this->postJson('/api/send', $requestBody, $this->headers)
            ->assertStatus(Response::HTTP_ACCEPTED);

        $this->assertDatabaseHas('custom_emails', [
            'attachments' => json_encode([
                'name' => $requestBody['data'][0]['attachments']['name'],
                'content' => $requestBody['data'][0]['attachments']['content']
            ])
        ]);

        Mail::assertQueued(SendCustomEmail::class, 1);
    }

    /** @test */
    public function unAuthorisedUserCanNotSendEmails() {
        Mail::fake();

        $requestBody['data'][] =  [
            'email' => $this->faker->email,
            'body' => $this->faker->text,
            'subject' => $this->faker->text(20)
        ];

        $this->postJson('/api/send', $requestBody)
            ->assertStatus(Response::HTTP_UNAUTHORIZED);

        Mail::assertNotQueued(SendCustomEmail::class);
    }

    /** @test */
    public function authorisedUserCanNotSendEmailsWithInvalidRequestBody() {
        Mail::fake();

        $requestBody['data'][] =  [
            'email' => $this->faker->text,
            'body' => $this->faker->text,
            'subject' => $this->faker->text(20)
        ];

        $this->postJson('/api/send', $requestBody, $this->headers)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        Mail::assertNotQueued(SendCustomEmail::class);
    }

    /** @test */
    public function authorisedUserCanViewAllEmailsSent() {
        $data = CustomEmail::factory(2)->create();

        $this->getJson('/api/list', $this->headers)
            ->assertOk()
            ->assertJsonStructure([ 'message', 'data' ])
            ->assertJsonCount(2, 'data.data')
            ->assertJson([
                'data' => [
                    'data' => [
                        [
                            'email' => $data->first()->email,
                            'body' => $data->first()->body,
                            'subject' => $data->first()->subject,
                        ],
                        [
                            'email' => $data->last()->email,
                            'body' => $data->last()->body,
                            'subject' => $data->last()->subject,
                        ]
                    ]
                ]
            ]);

    }

    private function generateBase64String() {
        return "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";
    }
}
