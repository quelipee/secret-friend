<?php

namespace App\Http\Controllers;

use App\Http\DTO\Group;
use App\Http\Interfaces\GroupsContracts;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class GroupsController extends Controller
{
    public function __construct(
        protected GroupsContracts $groupsContracts
    ){}

    public function store(Request $request): JsonResponse
    {
        $group = $this->groupsContracts->addGroups(Group::GroupValidatedFromRequest($request));
        return response()->json([
            'message' => "Group added successfully",
            'data' => $group
        ], ResponseAlias::HTTP_CREATED);
    }

    public function storeParticipant(Request $request, string $groupId): JsonResponse
    {
        $participant = $this->groupsContracts->addParticipantToGroup($request, $groupId);
        return response()->json([
            'message' => "Participant added successfully",
            'data' => $participant
        ], ResponseAlias::HTTP_CREATED);
    }

    public function createSecretSantaMatches(string $groupId) : JsonResponse
    {
        $match = $this->groupsContracts->generateSecretSantaPairs($groupId);
        return response()->json([
            'message' => "Match added successfully",
            'data' => $match
        ], ResponseAlias::HTTP_CREATED);
    }

    public function getParticipantGiftReceiver(string $groupId, string $participantId): JsonResponse
    {
        $receiver = $this->groupsContracts->retrieveAssignedRecipient($groupId, $participantId);
        return response()->json([
            'message' => "Receiver added successfully",
            'data' => $receiver
        ], ResponseAlias::HTTP_OK);
    }
}
