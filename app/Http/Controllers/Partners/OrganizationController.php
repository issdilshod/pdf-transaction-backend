<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use App\Models\Partners\Organization;
use App\Services\Partners\OrganizationService;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    
    private $organizationService;

    public  function __construct()
    {
        $this->organizationService = new OrganizationService();
    }

    /**     @OA\GET(
      *         path="/api/organization",
      *         operationId="get_organizations",
      *         tags={"Partners"},
      *         summary="Get organizations",
      *         description="Get organizations",
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function index()
    {
        $organizations = $this->organizationService->get_organizations();
        return $organizations;
    }

    /**     @OA\POST(
      *         path="/api/organization",
      *         operationId="create_organization",
      *         tags={"Partners"},
      *         summary="Create organization",
      *         description="Create organization",
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={"name"},
      *                         @OA\Property(property="name", type="text")
      *                     ),
      *                 ),
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *             @OA\Response(response=409, description="Conflict"),
      *     )
      */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required'
        ]);

        $response = $this->organizationService->create_organization($validated);
        return $response;
    }

    /**     @OA\GET(
      *         path="/api/organization/{id}",
      *         operationId="get_organization",
      *         tags={"Partners"},
      *         summary="Get organization",
      *         description="Get organization",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="organization id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function show(Organization $organization)
    {
        $organization = $this->organizationService->get_organization($organization);
        return $organization;
    }

    /**     @OA\PUT(
      *         path="/api/organization/{id}",
      *         operationId="update_organization",
      *         tags={"Partners"},
      *         summary="Update organization",
      *         description="Update organization",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="organization id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\RequestBody(
      *                 @OA\JsonContent(),
      *                 @OA\MediaType(
      *                     mediaType="multipart/form-data",
      *                     @OA\Schema(
      *                         type="object",
      *                         required={},
      *                         @OA\Property(property="name", type="text")
      *                     ),
      *                 ),
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function update(Request $request, Organization $organization)
    {
        $validated = $request->validate([
            'name' => ''
        ]);

        $response = $this->organizationService->update_organization($validated, $organization);
        return $response;
    }

    /**     @OA\DELETE(
      *         path="/api/organization/{id}",
      *         operationId="delete_organization",
      *         tags={"Partners"},
      *         summary="Delete organization",
      *         description="Delete organization",
      *             @OA\Parameter(
      *                 name="id",
      *                 in="path",
      *                 description="organization id",
      *                 @OA\Schema(type="integer"),
      *                 required=true
      *             ),
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function destroy(Organization $organization)
    {
        $this->organizationService->delete_organization($organization);
    }

    /**     @OA\GET(
      *         path="/api/organization-count",
      *         operationId="get_organizationsCount",
      *         tags={"Partners"},
      *         summary="Get organizations count",
      *         description="Get organizations count",
      *             @OA\Response(response=200, description="Successfully"),
      *             @OA\Response(response=400, description="Bad request"),
      *             @OA\Response(response=401, description="Not Authorized"),
      *             @OA\Response(response=404, description="Resource Not Found"),
      *     )
      */
    public function count()
    {
        $organizations_count = $this->organizationService->get_count();
        return $organizations_count;
    }
}
