<?php namespace App\Http\Controllers;

use App\Marvel\Characters;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class Pagecontroller extends Controller
{

    /**
     * @var Characters
     */
    private $characters;

    public function __construct(Characters $characters)
    {

        $this->characters = $characters;
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function home()
    {
        return view('home');
    }

    public function start()
    {
        Session::forget('currentRound');
        Session::forget('round');
        Session::forget('charactersInGame');
        Session::regenerate();

        $charactersInGame = $this->characters->all(['nameStartsWith' => 'The '])['data']['results'];

        $charactersInGame = $this->characters->removeCharactersWithoutImage($charactersInGame);

        Session::put('charactersInGame', $charactersInGame);

        //var_dump(collect(Session::get('charactersInGame'))->lists('id'));

        $opponents = $this->characters->getOpponents($charactersInGame);

        $round = 1;
        Session::put('round', $round);
        Session::put('currentOpponents', $opponents);

        $return = [
            'opponents' => $opponents,
            'round'     => $round
        ];

        return view('game', $return);
    }

    public function game()
    {

        $winnerId = (int) \Input::get('winnerId');
        $loserId = $this->getLoser(Session::get('currentOpponents'), $winnerId);
        $winner = $this->characters->findById($winnerId, Session::get('currentOpponents'));
        $charactersInGame = $this->characters->removeIds(Session::get('charactersInGame'), [$loserId, $winnerId]);

        Session::put('charactersInGame', $charactersInGame);
        $round = Session::get('round') + 1;


        // var_dump(collect(Session::get('charactersInGame'))->lists('id'));
        $challenger = $this->characters->random(1, Session::get('charactersInGame'));

        Session::put('currentRound', [$winner, $challenger]);
        Session::put('currentOpponents', [$winner, $challenger]);

        if (!$challenger) {
            return view('result', ['winner' => $winner]);
        }

        // Return the selected character and a new one
        $return = [
            'opponents' => [$winner, $challenger],
            'round'     => $round
        ];

        return view('game', $return);
    }

    private function getLoser($currentRound, $winnerId)
    {
        $currentRound = collect($currentRound);

        $loser = $currentRound->filter(function ($opponent) use ($winnerId) {
            if ($opponent['id'] != $winnerId) {
                return true;
            }
        });

        return $loser->first()['id'];
    }

}
