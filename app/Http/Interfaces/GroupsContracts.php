<?php

namespace App\Http\Interfaces;

use App\Http\DTO\Group;
use App\Models\Groups;
use App\Models\Participants;
use Illuminate\Http\Request;

interface GroupsContracts
{
    public function addGroups(Group $group): Groups;
    public function addParticipantToGroup(Request $request, string $groupId): Participants;
    public function generateSecretSantaPairs(string $groupId);
}
