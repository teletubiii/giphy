<?php
namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\API\GiphyController;
use App\Models\FavoriteGif;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;

class GiphyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_gifs_successfully()
    {
        // Mock de la respuesta HTTP
        Http::fake([
            'api.giphy.com/*' => Http::response([
                'success' => true,
                'data' => [
                    [
                        "type" => "gif",
                        "id" => "elxZwVNCcL5hvktNFs",
                        "url" => "https://giphy.com/gifs/reaction-mood-elxZwVNCcL5hvktNFs",
                        "slug" => "reaction-mood-elxZwVNCcL5hvktNFs",
                        "bitly_gif_url" => "https://gph.is/2CY4dRN",
                        "bitly_url" => "https://gph.is/2CY4dRN",
                        "embed_url" => "https://giphy.com/embed/elxZwVNCcL5hvktNFs",
                        "username" => "",
                        "source" => "https://www.reddit.com/r/reactiongifs/",
                        "title" => "Cheeseburger GIF by MOODMAN",
                        "rating" => "g",
                        "content_url" => "",
                        "source_tld" => "www.reddit.com",
                        "source_post_url" => "https://www.reddit.com/r/reactiongifs/",
                        "is_sticker" => 0,
                        "import_datetime" => "2018-09-11 23:56:20",
                        "trending_datetime" => "2019-09-18 16:00:51",
                        "images" => [
                            "original" => [
                                "height" => "340",
                                "width" => "500",
                                "size" => "205261",
                                "url" => "https://media1.giphy.com/media/elxZwVNCcL5hvktNFs/giphy.gif",
                                "mp4_size" => "181439",
                                "mp4" => "https://media1.giphy.com/media/elxZwVNCcL5hvktNFs/giphy.mp4",
                                "webp_size" => "170290",
                                "webp" => "https://media1.giphy.com/media/elxZwVNCcL5hvktNFs/giphy.webp",
                                "frames" => "10",
                                "hash" => "900b2a420befa9b472831c05dc5fcdc2"
                            ],
                            // Incluye otros formatos de imagen si es necesario
                        ],
                        "analytics_response_payload" => "e=ZXZlbnRfdHlwZT1HSUZfU0VBUkNIJmNpZD1lMDQ1Y2IzZnhvdDh3ZzgwaXJ2eTE4MHZpMnhyOTAwcjdrdml2eTlpZHIycnprZXAmZ2lmX2lkPWVseFp3Vk5DY0w1aHZrdE5GcyZjdD1n",
                        "analytics" => [
                            "onload" => [
                                "url" => "https://giphy-analytics.giphy.com/v2/pingback_simple?analytics_response_payload=e%3DZXZlbnRfdHlwZT1HSUZfU0VBUkNIJmNpZD1lMDQ1Y2IzZnhvdDh3ZzgwaXJ2eTE4MHZpMnhyOTAwcjdrdml2eTlpZHIycnprZXAmZ2lmX2lkPWVseFp3Vk5DY0w1aHZrdE5GcyZjdD1n&action_type=SEEN"
                            ],
                            "onclick" => [
                                "url" => "https://giphy-analytics.giphy.com/v2/pingback_simple?analytics_response_payload=e%3DZXZlbnRfdHlwZT1HSUZfU0VBUkNIJmNpZD1lMDQ1Y2IzZnhvdDh3ZzgwaXJ2eTE4MHZpMnhyOTAwcjdrdml2eTlpZHIycnprZXAmZ2lmX2lkPWVseFp3Vk5DY0w1aHZrdE5GcyZjdD1n&action_type=CLICK"
                            ],
                            "onsent" => [
                                "url" => "https://giphy-analytics.giphy.com/v2/pingback_simple?analytics_response_payload=e%3DZXZlbnRfdHlwZT1HSUZfU0VBUkNIJmNpZD1lMDQ1Y2IzZnhvdDh3ZzgwaXJ2eTE4MHZpMnhyOTAwcjdrdml2eTlpZHIycnprZXAmZ2lmX2lkPWVseFp3Vk5DY0w1aHZrdE5GcyZjdD1n&action_type=SENT"
                            ]
                        ],
                        "alt_text" => ""
                    ]
                ],
                'message' => 'GIFs retrieved successfully.'
            ], 200)
        ]);
    
        // Crear una instancia del controlador y una solicitud simulada
        $controller = new GiphyController();
        $request = Request::create('/api/gifs', 'GET', [
            'query' => 'funny',
            'limit' => 10,
            'offset' => 0,
        ]);
    
        // Llamar al método index y obtener la respuesta
        $response = $controller->index($request);
    
        // Convertir la respuesta en una instancia de TestResponse
        $testResponse = new TestResponse($response);
    
        // Verificar que la respuesta tiene un estado 200
        $testResponse->assertStatus(200);
        // Verificar que la respuesta contiene los datos correctos
        $testResponse->assertJson([
            'success' => true,
            'data' => [
                [
                    "type" => "gif",
                    "id" => "elxZwVNCcL5hvktNFs",
                    "url" => "https://giphy.com/gifs/reaction-mood-elxZwVNCcL5hvktNFs",
                    "slug" => "reaction-mood-elxZwVNCcL5hvktNFs",
                    "bitly_gif_url" => "https://gph.is/2CY4dRN",
                    "bitly_url" => "https://gph.is/2CY4dRN",
                    "embed_url" => "https://giphy.com/embed/elxZwVNCcL5hvktNFs",
                    "username" => "",
                    "source" => "https://www.reddit.com/r/reactiongifs/",
                    "title" => "Cheeseburger GIF by MOODMAN",
                    "rating" => "g",
                    "content_url" => "",
                    "source_tld" => "www.reddit.com",
                    "source_post_url" => "https://www.reddit.com/r/reactiongifs/",
                    "is_sticker" => 0,
                    "import_datetime" => "2018-09-11 23:56:20",
                    "trending_datetime" => "2019-09-18 16:00:51",
                    "images" => [
                        "original" => [
                            "height" => "340",
                            "width" => "500",
                            "size" => "205261",
                            "url" => "https://media1.giphy.com/media/elxZwVNCcL5hvktNFs/giphy.gif",
                            "mp4_size" => "181439",
                            "mp4" => "https://media1.giphy.com/media/elxZwVNCcL5hvktNFs/giphy.mp4",
                            "webp_size" => "170290",
                            "webp" => "https://media1.giphy.com/media/elxZwVNCcL5hvktNFs/giphy.webp",
                            "frames" => "10",
                            "hash" => "900b2a420befa9b472831c05dc5fcdc2"
                        ],
                    ],
                    "analytics_response_payload" => "e=ZXZlbnRfdHlwZT1HSUZfU0VBUkNIJmNpZD1lMDQ1Y2IzZnhvdDh3ZzgwaXJ2eTE4MHZpMnhyOTAwcjdrdml2eTlpZHIycnprZXAmZ2lmX2lkPWVseFp3Vk5DY0w1aHZrdE5GcyZjdD1n",
                    "analytics" => [
                        "onload" => [
                            "url" => "https://giphy-analytics.giphy.com/v2/pingback_simple?analytics_response_payload=e%3DZXZlbnRfdHlwZT1HSUZfU0VBUkNIJmNpZD1lMDQ1Y2IzZnhvdDh3ZzgwaXJ2eTE4MHZpMnhyOTAwcjdrdml2eTlpZHIycnprZXAmZ2lmX2lkPWVseFp3Vk5DY0w1aHZrdE5GcyZjdD1n&action_type=SEEN"
                        ],
                        "onclick" => [
                            "url" => "https://giphy-analytics.giphy.com/v2/pingback_simple?analytics_response_payload=e%3DZXZlbnRfdHlwZT1HSUZfU0VBUkNIJmNpZD1lMDQ1Y2IzZnhvdDh3ZzgwaXJ2eTE4MHZpMnhyOTAwcjdrdml2eTlpZHIycnprZXAmZ2lmX2lkPWVseFp3Vk5DY0w1aHZrdE5GcyZjdD1n&action_type=CLICK"
                        ],
                        "onsent" => [
                            "url" => "https://giphy-analytics.giphy.com/v2/pingback_simple?analytics_response_payload=e%3DZXZlbnRfdHlwZT1HSUZfU0VBUkNIJmNpZD1lMDQ1Y2IzZnhvdDh3ZzgwaXJ2eTE4MHZpMnhyOTAwcjdrdml2eTlpZHIycnprZXAmZ2lmX2lkPWVseFp3Vk5DY0w1aHZrdE5GcyZjdD1n&action_type=SENT"
                        ]
                    ],
                    "alt_text" => ""
                ]
            ],
            'message' => 'GIFs retrieved successfully.'
        ]);
    }

    public function test_show_returns_gif_successfully()
    {
        // Mock de la respuesta HTTP
        Http::fake([
            'api.giphy.com/v1/gifs/*' => Http::response([
                'success' => true,
                'data' => [
                    'type' => 'gif',
                    'id' => '5f9Qy99suPqYfYIqwH',
                    'url' => 'https://giphy.com/gifs/buzzfeed-burger-cheeseburger-national-day-5f9Qy99suPqYfYIqwH',
                    'slug' => 'buzzfeed-burger-cheeseburger-national-day-5f9Qy99suPqYfYIqwH',
                    'bitly_gif_url' => 'https://gph.is/g/Z20d8J8',
                    'bitly_url' => 'https://gph.is/g/Z20d8J8',
                    'embed_url' => 'https://giphy.com/embed/5f9Qy99suPqYfYIqwH',
                    'username' => 'buzzfeed',
                    'source' => 'https://www.youtube.com/watch?v=Yql-9LHorTo',
                    'title' => 'Double Cheeseburger Burger GIF by BuzzFeed',
                    'rating' => 'g',
                    'content_url' => '',
                    'source_tld' => 'www.youtube.com',
                    'source_post_url' => 'https://www.youtube.com/watch?v=Yql-9LHorTo',
                    'is_sticker' => 0,
                    'import_datetime' => '2023-09-13 19:58:51',
                    'trending_datetime' => '0000-00-00 00:00:00',
                    'images' => [
                        'original' => [
                            'height' => '270',
                            'width' => '480',
                            'size' => '856467',
                            'url' => 'https://media1.giphy.com/media/5f9Qy99suPqYfYIqwH/giphy.gif?cid=e045cb3ff5tlblewir8n36y0lze796k6rigxc11p62sgnazv&ep=v1_gifs_gifId&rid=giphy.gif&ct=g',
                            'mp4_size' => '100922',
                            'mp4' => 'https://media1.giphy.com/media/5f9Qy99suPqYfYIqwH/giphy.mp4?cid=e045cb3ff5tlblewir8n36y0lze796k6rigxc11p62sgnazv&ep=v1_gifs_gifId&rid=giphy.mp4&ct=g',
                            'webp_size' => '252482',
                            'webp' => 'https://media1.giphy.com/media/5f9Qy99suPqYfYIqwH/giphy.webp?cid=e045cb3ff5tlblewir8n36y0lze796k6rigxc11p62sgnazv&ep=v1_gifs_gifId&rid=giphy.webp&ct=g',
                            'frames' => '18',
                            'hash' => '40ea1c966f84e904cb4d4f10cabb0ace'
                        ],
                        // Aquí puedes agregar otras variantes de imágenes si las necesitas
                    ],
                    'user' => [
                        'avatar_url' => 'https://media2.giphy.com/avatars/buzzfeed/7FY6Nc0QS1kn.gif',
                        'banner_image' => '',
                        'banner_url' => '',
                        'profile_url' => 'https://giphy.com/buzzfeed/',
                        'username' => 'buzzfeed',
                        'display_name' => 'BuzzFeed',
                        'description' => 'BuzzFeed has breaking news, vital journalism, quizzes, videos, celeb news, Tasty food videos, recipes, DIY hacks, and all the trending buzz you\'ll want to share ...',
                        'instagram_url' => 'https://instagram.com/buzzfeed',
                        'website_url' => 'https://www.buzzfeed.com',
                        'is_verified' => true
                    ],
                    'analytics_response_payload' => 'e=ZXZlbnRfdHlwZT1HSUZfQllfSUQmY2lkPWUwNDVjYjNmZjV0bGJsZXdpcjhuMzZ5MGx6ZTc5Nms2cmlneGMxMXA2MnNnbmF6diZnaWZfaWQ9NWY5UXk5OXN1UHFZZllJcXdIJmN0PWc',
                    'analytics' => [
                        'onload' => [
                            'url' => 'https://giphy-analytics.giphy.com/v2/pingback_simple?analytics_response_payload=e%3DZXZlbnRfdHlwZT1HSUZfQllfSUQmY2lkPWUwNDVjYjNmZjV0bGJsZXdpcjhuMzZ5MGx6ZTc5Nms2cmlneGMxMXA2MnNnbmF6diZnaWZfaWQ9NWY5UXk5OXN1UHFZZllJcXdIJmN0PWc&action_type=SEEN'
                        ],
                        'onclick' => [
                            'url' => 'https://giphy-analytics.giphy.com/v2/pingback_simple?analytics_response_payload=e%3DZXZlbnRfdHlwZT1HSUZfQllfSUQmY2lkPWUwNDVjYjNmZjV0bGJsZXdpcjhuMzZ5MGx6ZTc5Nms2cmlneGMxMXA2MnNnbmF6diZnaWZfaWQ9NWY5UXk5OXN1UHFZZllJcXdIJmN0PWc&action_type=CLICK'
                        ],
                        'onsent' => [
                            'url' => 'https://giphy-analytics.giphy.com/v2/pingback_simple?analytics_response_payload=e%3DZXZlbnRfdHlwZT1HSUZfQllfSUQmY2lkPWUwNDVjYjNmZjV0bGJsZXdpcjhuMzZ5MGx6ZTc5Nms2cmlneGMxMXA2MnNnbmF6diZnaWZfaWQ9NWY5UXk5OXN1UHFZZllJcXdIJmN0PWc&action_type=SENT'
                        ]
                    ],
                    'alt_text' => ''
                ],
            ], 200)
        ]);

        // Crear una instancia del controlador
        $controller = new GiphyController();
        
        // Llamar al método show y obtener la respuesta
        $response = $controller->show('5f9Qy99suPqYfYIqwH');

        // Convertir la respuesta en una instancia de TestResponse
        $testResponse = new TestResponse($response);

        // Verificar que la respuesta tiene un estado 200
        $testResponse->assertStatus(200);
        // Verificar que la respuesta contiene los datos correctos
        $testResponse->assertJson([
            'success' => true,
            'data' => [
                'type' => 'gif',
                'id' => '5f9Qy99suPqYfYIqwH',
                'url' => 'https://giphy.com/gifs/buzzfeed-burger-cheeseburger-national-day-5f9Qy99suPqYfYIqwH',
                'slug' => 'buzzfeed-burger-cheeseburger-national-day-5f9Qy99suPqYfYIqwH',
                'bitly_gif_url' => 'https://gph.is/g/Z20d8J8',
                'bitly_url' => 'https://gph.is/g/Z20d8J8',
                'embed_url' => 'https://giphy.com/embed/5f9Qy99suPqYfYIqwH',
                'username' => 'buzzfeed',
                'source' => 'https://www.youtube.com/watch?v=Yql-9LHorTo',
                'title' => 'Double Cheeseburger Burger GIF by BuzzFeed',
                'rating' => 'g',
                'content_url' => '',
                'source_tld' => 'www.youtube.com',
                'source_post_url' => 'https://www.youtube.com/watch?v=Yql-9LHorTo',
                'is_sticker' => 0,
                'import_datetime' => '2023-09-13 19:58:51',
                'trending_datetime' => '0000-00-00 00:00:00',
                'images' => [
                    'original' => [
                        'height' => '270',
                        'width' => '480',
                        'size' => '856467',
                        'url' => 'https://media1.giphy.com/media/5f9Qy99suPqYfYIqwH/giphy.gif?cid=e045cb3ff5tlblewir8n36y0lze796k6rigxc11p62sgnazv&ep=v1_gifs_gifId&rid=giphy.gif&ct=g',
                        'mp4_size' => '100922',
                        'mp4' => 'https://media1.giphy.com/media/5f9Qy99suPqYfYIqwH/giphy.mp4?cid=e045cb3ff5tlblewir8n36y0lze796k6rigxc11p62sgnazv&ep=v1_gifs_gifId&rid=giphy.mp4&ct=g',
                        'webp_size' => '252482',
                        'webp' => 'https://media1.giphy.com/media/5f9Qy99suPqYfYIqwH/giphy.webp?cid=e045cb3ff5tlblewir8n36y0lze796k6rigxc11p62sgnazv&ep=v1_gifs_gifId&rid=giphy.webp&ct=g',
                        'frames' => '18',
                        'hash' => '40ea1c966f84e904cb4d4f10cabb0ace'
                    ],
                ],
                'user' => [
                    'avatar_url' => 'https://media2.giphy.com/avatars/buzzfeed/7FY6Nc0QS1kn.gif',
                    'banner_image' => '',
                    'banner_url' => '',
                    'profile_url' => 'https://giphy.com/buzzfeed/',
                    'username' => 'buzzfeed',
                    'display_name' => 'BuzzFeed',
                    'description' => 'BuzzFeed has breaking news, vital journalism, quizzes, videos, celeb news, Tasty food videos, recipes, DIY hacks, and all the trending buzz you\'ll want to share ...',
                    'instagram_url' => 'https://instagram.com/buzzfeed',
                    'website_url' => 'https://www.buzzfeed.com',
                    'is_verified' => true
                ],
                'analytics_response_payload' => 'e=ZXZlbnRfdHlwZT1HSUZfQllfSUQmY2lkPWUwNDVjYjNmZjV0bGJsZXdpcjhuMzZ5MGx6ZTc5Nms2cmlneGMxMXA2MnNnbmF6diZnaWZfaWQ9NWY5UXk5OXN1UHFZZllJcXdIJmN0PWc',
                'analytics' => [
                    'onload' => [
                        'url' => 'https://giphy-analytics.giphy.com/v2/pingback_simple?analytics_response_payload=e%3DZXZlbnRfdHlwZT1HSUZfQllfSUQmY2lkPWUwNDVjYjNmZjV0bGJsZXdpcjhuMzZ5MGx6ZTc5Nms2cmlneGMxMXA2MnNnbmF6diZnaWZfaWQ9NWY5UXk5OXN1UHFZZllJcXdIJmN0PWc&action_type=SEEN'
                    ],
                    'onclick' => [
                        'url' => 'https://giphy-analytics.giphy.com/v2/pingback_simple?analytics_response_payload=e%3DZXZlbnRfdHlwZT1HSUZfQllfSUQmY2lkPWUwNDVjYjNmZjV0bGJsZXdpcjhuMzZ5MGx6ZTc5Nms2cmlneGMxMXA2MnNnbmF6diZnaWZfaWQ9NWY5UXk5OXN1UHFZZllJcXdIJmN0PWc&action_type=CLICK'
                    ],
                    'onsent' => [
                        'url' => 'https://giphy-analytics.giphy.com/v2/pingback_simple?analytics_response_payload=e%3DZXZlbnRfdHlwZT1HSUZfQllfSUQmY2lkPWUwNDVjYjNmZjV0bGJsZXdpcjhuMzZ5MGx6ZTc5Nms2cmlneGMxMXA2MnNnbmF6diZnaWZfaWQ9NWY5UXk5OXN1UHFZZllJcXdIJmN0PWc&action_type=SENT'
                    ]
                ],
                'alt_text' => ''
            
        ],
            'message' => 'GIF retrieved successfully.'
        ]);
    }

    public function test_store_favorite_successfully()
    {
        // Crear una instancia del controlador y una solicitud simulada
        $controller = new GiphyController();
        $request = Request::create('/api/gifs/favorite', 'POST', [
            'gif_id' => '1',
            'alias' => 'My Favorite GIF',
            'user_id' => 1,
        ]);

        // Llamar al método storeFavorite y obtener la respuesta
        $response = $controller->storeFavorite($request);

        // Convertir la respuesta en una instancia de TestResponse
        $testResponse = new TestResponse($response);

        // Verificar que la respuesta tiene un estado 200
        $testResponse->assertStatus(200);
        // Verificar que la respuesta contiene los datos correctos
        $testResponse->assertJson([
            'success' => true,
            'data' => [
                'gif_id' => '1',
                'alias' => 'My Favorite GIF',
                'user_id' => 1,
            ],
            'message' => 'GIF saved as favorite successfully.'
        ]);

        // Verificar que el GIF favorito fue guardado en la base de datos
        $this->assertDatabaseHas('favorite_gifs', [
            'gif_id' => '1',
            'alias' => 'My Favorite GIF',
            'user_id' => 1,
        ]);
    }
}
