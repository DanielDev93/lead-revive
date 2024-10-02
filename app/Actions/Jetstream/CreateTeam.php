<?php

namespace App\Actions\Jetstream;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Team;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\Events\AddingTeam;
use Laravel\Jetstream\Jetstream;

class CreateTeam implements CreatesTeams
{
    /**
     * Validate and create a new team for the given user.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return mixed
     */
    public function create($user, array $input)
    {
        $team_count   = Team::where('user_id', $user->id)->count();
        $subscription = Subscription::where('user_id', $user->id)->first();

        if (! $subscription) {
            notify()->warning('Please subscribe with a plan');
            return back();
        }

        $plan = Plan::where('plan_variation_id', $subscription->plan_variation_id)->first();

        if (! $plan || $team_count >= $plan->teams_limit) {
            notify()->warning('You have reached the team limit. To create a new team, please upgrade your subscription.');
            return back();
        } else {
            Gate::forUser($user)->authorize('create', Jetstream::newTeamModel());

            Validator::make($input, [
                'name' => ['required', 'string', 'max:255'],
            ])->validateWithBag('createTeam');

            AddingTeam::dispatch($user);

            return $user->ownedTeams()->create([
                'name'          => $input['name'],
                'personal_team' => false,
            ]);
        }
    }
}
