<?php

namespace bga\app\data {

    require_once('Model.php');
    require_once('Game.php');
    require_once __DIR__ . '/../Result.php';

    use bga\app\data\Result as Result;

    class Member extends Model
    {
        private $games = null;

        public function fullName()
        {
            return $this->data['first_name'] . ' ' . $this->data['last_name'];
        }

        public static function idColumn()
        {
            return 'member_id';
        }

        public static function tableName()
        {
            return 'member';
        }

        public static function columns()
        {
            return array('first_name', 'last_name', 'email', 'phone');
        }





        public function loadGames()
        {
            $findGames = $this->findGames();

            switch($findGames->status())
            {
                case Result::SUCCESS:
                    $this->games = $findGames->models();
                    return true;
                    break;
                case Result::EMPTY:
                    $this->games = [];
                    return false;
                default:
                    $this->games = null;
                    die("Error in find games");
                    break;
            }

        }

        public function toggleGame($gameId)
        {
            // SELECT COUNT(1) FROM table 1 WHERE some_condition.
        }

        public function getGames()
        {
            return $this->games;
        }

        public function hasGame(Game $game)
        {
            if (is_null($this->games))
                die("games was null when has game called");

            if (empty($this->games))
                return false;

            foreach ($this->games as $g) {
                if ($game->getId() === $g->getId())
                    return true;
            }

            return false;
        }

        public function hasGameId($gameId)
        {
            if (empty($this->games))
                return false;

            foreach ($this->games as $g) {
                if ($gameId === $g->getId())
                    return true;
            }

            return false;
        }






        public function removeGame($game)
        {
            $id = $this->getId();
            $gameId = $game->getId();



            $sql = "DELETE FROM member_game WHERE member_game.member_id = $id AND " .
                   "member_game.game_id = $gameId";
            try {
                $deleteStatement = self::db()->prepare($sql);
                $deleteStatement->execute();
            } catch (\PDOException $ex) {
                return Result::createError($ex->getMessage());
            }

            return $deleteStatement->rowCount() > 0
                ? Result::createSuccess()
                : Result::createError("Error removing game from member");
        }

        public function addGame($game)
        {
            //$sql = "INSERT INTO member_game (member_id, game_id) VALUES (100, 200)";

            $sql = "INSERT INTO member_game (member_id, game_id) VALUES (:member_id, :game_id)";
            $insert = self::db()->prepare($sql);

            $insert->bindValue(':member_id', $this->getId());
            $insert->bindValue(':game_id', $game->getId());

            // Insert the row.
            return $this->execute($insert);
        }


        public function findGames()
        {
            $memberId = $this->getId();

            $sql = <<<NOW
SELECT * from game
INNER JOIN member_game ON game.game_id = member_game.game_id
INNER JOIN member ON member.member_id = member_game.member_id
WHERE member.member_id = $memberId;
NOW;

            return Game::fetchAll($sql);
        }
    }
}