<?php

namespace App\Http\Services;

use App\Http\DTO\Group;
use App\Http\Interfaces\GroupsContracts;
use App\Models\Groups;
use App\Models\MatchPair;
use App\Models\Participants;
use Illuminate\Http\Request;

class GroupsService implements GroupsContracts
{
    public function addGroups(Group $group): Groups
    {
        $new_group = new Groups([
            'name' => $group->name,
        ]);
        $new_group->save();
        return $new_group;
    }

    public function addParticipantToGroup(Request $request, string $groupId): Participants
    {
        $participant = new Participants([
            'name' => $request->get('name'),
            'group_id' => $groupId
        ]);
        $participant->save();
        return $participant;
    }

    public function generateSecretSantaPairs(string $groupId): array
    {
        $id = [];
        $relations = Groups::with('participants')->where('id',$groupId)->first()->toArray();
        foreach ($relations['participants'] as $participant) {
            $id[] = $participant['id'];
        }
        shuffle($id);
        $matches = [];
        for ($i = 0; $i < count($id); $i++)
        {
            $giver = $id[$i];
            $receiver = $id[($i + 1) % count($id)];
            $receiver_exists = MatchPair::query()->where('receiver_id',$receiver)->exists();
            $giver_exists = MatchPair::query()->where('giver_id',$giver)->exists();

            while ($receiver_exists || $giver_exists || $receiver == $giver)
            {
                shuffle($id);
                $receiver = $id[($i + 1) % count($id)];
                $receiver_exists = MatchPair::query()->where('receiver_id',$receiver)->exists();
                $giver_exists = MatchPair::query()->where('giver_id',$giver)->exists();
            }
            $match = new MatchPair([
                'group_id' => $groupId,
                'giver_id' => $giver,
                'receiver_id' => $receiver,
            ]);
            $match->save();
            $matches[] = $match;
        }
        return $matches;
    }

    public function retrieveAssignedRecipient(string $groupId, string $participantId) : Participants
    {
        $match = MatchPair::query()
            ->where('group_id',$groupId)
            ->where('giver_id',$participantId)
            ->first();

        return $match->receiver;
    }
}
