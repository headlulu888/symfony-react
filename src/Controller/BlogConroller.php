<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BlogConroller
 * @package App\Controller
 * @Route("/blog")
 */
class BlogConroller extends AbstractController
{
    private const POSTS = [
        [
            "id" => 1,
            "slug" => "hello-world",
            "title" => "Hello World"
        ],
        [
            "id" => 2,
            "slug" => "another-post",
            "title" => "This is another post!"
        ],
        [
            "id" => 3,
            "slug" => "last-example",
            "title" => "This is the last example!"
        ]
    ];

    /**
     * @Route("/{page}", name="blog_list", defaults={"page": 5})
     * @param int $page
     * @param Request $request
     * @return JsonResponse
     */
    public function list($page = 1, Request $request)
    {
        $limit = $request->get("limit", 10);

        // return new Response($limit);

        return $this->json(
            [
                "page" => $page,
                "limit" => $limit,
                "data" => array_map(function($item) {
                    return $this->generateUrl("blog_by_slug", ["slug" => $item["slug"]]);
                }, self::POSTS)
            ]
        );
    }

    /**
     * @Route("/post/{id}", name="blog_by_id", requirements={"id"="\d+"})
     * @param $id
     * @return JsonResponse
     */
    public function post($id)
    {
        return $this->json(
            self::POSTS[array_search($id, array_column(self::POSTS, "id"))]
        );
    }

    /**
     * @Route("/post/{slug}", name="blog_by_slug")
     * @param $slug
     * @return JsonResponse
     */
    public function postBySlug($slug)
    {
        return $this->json(
            self::POSTS[array_search($slug, array_column(self::POSTS, "slug"))]
        );
    }
}