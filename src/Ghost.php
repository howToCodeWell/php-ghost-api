<?php

namespace M1guelpf\GhostAPI;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Ghost
{
    /** @var Client */
    protected Client $client;

    /** @var string */
    protected string $host;

    /** @var null|string */
    protected ?string $apiToken = null;

    /** @var string */
    protected string $baseUrl;

    /**
     * @param string $host
     * @param null|string $apiToken
     * @param string $apiVersion
     */
    public function __construct(string $host, ?string $apiToken, string $apiVersion = 'v2')
    {
        $this->client = new Client();

        $this->apiToken = $apiToken;

        $this->baseUrl = "$host/ghost/api/$apiVersion/content/";
    }

    /**
     * @param string $apiToken
     *
     * @return self
     */
    public function connect(string $apiToken): self
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param Client $client
     * @return Ghost
     */
    public function setClient(Client $client): self
    {
        if ($client instanceof Client) {
            $this->client = $client;
        }

        return $this;
    }

    /**
     * @param string $include
     * @param string $fields
     * @param string $filter
     * @param string $limit
     * @param string $page
     * @param string $order
     * @param string $format
     *
     * @return array
     * @throws Exception
     */
    public function getPosts(string $include = '', string $fields = '', string $filter = '', string $limit = '', string $page = '', string $order = '', string $format = '')
    {
        return $this->get('posts', compact('include', 'fields', 'filter', 'limit', 'page', 'order', 'format'));
    }

    /**
     * @param string $resource
     * @param array $query
     *
     * @return array
     * @throws Exception
     */
    public function get(string $resource, array $query = []): array
    {
        $apiToken = $this->getAPIToken();
        if (empty($apiToken)) {
            throw new Exception('Ghost API token must be set');
        }
        if (!empty($query)) {
            $query = array_unique(array_merge(array_filter($query), ['key' => $apiToken]), SORT_REGULAR);
        } else {
            $query = ['key' => $apiToken];
        }

        $results = file_get_contents("{$this->baseUrl}/{$resource}?" . http_build_query($query));

        return json_decode($results, true);
    }

    /**
     * @return string|null
     */
    public function getAPIToken(): ?string
    {
        return $this->apiToken;
    }

    /**
     * @param string $postId
     * @param string $include
     * @param string $fields
     *
     * @return array
     * @throws Exception
     */
    public function getPost(string $postId, string $include = '', string $fields = ''): array
    {
        return $this->get("posts/$postId", compact('include', 'fields'));
    }

    /**
     * @param string $slug
     * @param string $include
     * @param string $fields
     *
     * @return array
     * @throws Exception
     */
    public function getPostBySlug(string $slug, string $include = '', string $fields = ''): array
    {
        return $this->get("posts/slug/$slug", compact('include', 'fields'));
    }

    /**
     * @param string $include
     * @param string $fields
     * @param string $filter
     * @param string $limit
     * @param string $page
     * @param string $order
     *
     * @return array
     * @throws Exception
     */
    public function getAuthors(string $include = '', string $fields = '', string $filter = '', string $limit = '', string $page = '', string $order = ''): array
    {
        return $this->get('authors', compact('include', 'fields', 'filter', 'limit', 'page', 'order'));
    }

    /**
     * @param string $authorId
     * @param string $include
     * @param string $fields
     *
     * @return array
     * @throws Exception
     */
    public function getAuthor(string $authorId, string $include = '', string $fields = ''): array
    {
        return $this->get("authors/$authorId", compact('include', 'fields'));
    }

    /**
     * @param string $slug
     * @param string $include
     * @param string $fields
     *
     * @return array
     * @throws Exception
     */
    public function getAuthorBySlug(string $slug, string $include = '', string $fields = ''): array
    {
        return $this->get("authors/slug/$slug", compact('include', 'fields'));
    }

    /**
     * @param string $include
     * @param string $fields
     * @param string $filter
     * @param string $limit
     * @param string $page
     * @param string $order
     *
     * @return array
     * @throws Exception
     */
    public function getTags(string $include = '', string $fields = '', string $filter = '', string $limit = '', string $page = '', string $order = ''): array
    {
        return $this->get('tags', compact('include', 'fields', 'filter', 'limit', 'page', 'order'));
    }

    /**
     * @param string $tagsId
     * @param string $include
     * @param string $fields
     *
     * @return array
     * @throws Exception
     */
    public function getTag(string $tagsId, string $include = '', string $fields = ''): array
    {
        return $this->get("tags/$tagsId", compact('include', 'fields'));
    }

    /**
     * @param string $slug
     * @param string $include
     * @param string $fields
     *
     * @return array
     * @throws Exception
     */
    public function getTagBySlug(string $slug, string $include = '', string $fields = ''): array
    {
        return $this->get("tags/slug/$slug", compact('include', 'fields'));
    }

    /**
     * @param string $include
     * @param string $fields
     * @param string $filter
     * @param string $limit
     * @param string $page
     * @param string $order
     * @param string $format
     *
     * @return array
     * @throws Exception
     */
    public function getPages(string $include = '', string $fields = '', string $filter = '', string $limit = '', string $page = '', string $order = '', string $format = ''): array
    {
        return $this->get('pages', compact('include', 'fields', 'filter', 'limit', 'page', 'order', 'format'));
    }

    /**
     * @param string $pageId
     * @param string $include
     * @param string $fields
     *
     * @return array
     * @throws Exception
     */
    public function getPage(string $pageId, string $include = '', string $fields = ''): array
    {
        return $this->get("pages/$pageId", compact('include', 'fields'));
    }

    /**
     * @param string $slug
     * @param string $include
     * @param string $fields
     *
     * @return array
     * @throws Exception
     */
    public function getPageBySlug(string $slug, string $include = '', string $fields = ''): array
    {
        return $this->get("pages/slug/$slug", compact('include', 'fields'));
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getSettings(): array
    {
        return $this->get('settings');
    }

    /**
     * @param string $resource
     * @param array $rawData
     * @return array
     * @throws GuzzleException
     */
    public function post(string $resource, array $rawData = []): array
    {
        return $this->handleCall('POST', $resource, [], $rawData);
    }

    /**
     * @param string $method HTTP method
     * @param string $resource Resource to invoke at the HyperHost API
     * @param array $query Request query string to pass in the URL
     * @param array $rawData Request body
     *
     * @return array
     * @throws GuzzleException
     * @throws Exception
     */
    protected function handleCall(string $method, string $resource, array $query, array $rawData): array
    {
        $apiToken = $this->getAPIToken();
        if (empty($apiToken)) {
            throw new Exception('Ghost API token must be set');
        }

        $data['headers'] = [
            'User-Agent' => 'php-ghost-api',
        ];

        if (!empty($query)) {
            $data['query'] = array_unique(array_merge($query, ['key' => $apiToken]), SORT_REGULAR);
        } else {
            $data['query'] = ['key' => $apiToken];
        }

        if (!empty($rawData)) {
            $data['json'] = $rawData;
        }

        $results = $this->client
            ->request($method, "{$this->baseUrl}/{$resource}", $data)
            ->getBody()
            ->getContents();

        return json_decode($results, true);
    }

    /**
     * @param string $resource
     * @param array $rawData
     * @return array
     * @throws GuzzleException
     */
    public function put(string $resource, array $rawData = []): array
    {
        return $this->handleCall('PUT', $resource, [], $rawData);
    }

    /**
     * @param string $resource
     * @param array $rawData
     * @return array
     * @throws GuzzleException
     */
    public function delete(string $resource, array $rawData = []): array
    {
        return $this->handleCall('DELETE', $resource, [], $rawData);
    }
}
