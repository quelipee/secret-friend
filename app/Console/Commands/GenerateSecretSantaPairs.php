<?php

namespace App\Console\Commands;

use App\Http\Controllers\GroupsController;
use App\Models\Participants;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class GenerateSecretSantaPairs extends Command
{
    public function __construct(
        protected GroupsController $groupsController,
        public string $logout = 'nao'
    )
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-secret-santa-pairs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @throws Exception
     */
    public function handle(): void
    {
        while ($this->logout == 'nao') {
            $this->info('Bem vindo ao amigo secreto!!');
            $result = $this->choice('Deseja criar um grupo?',['sim','nao']);

            match (strtolower($result))
            {
                'sim' => $this->group(),
                'nao' => $this->join(),
                default => throw new Exception('Erro ao criar um grupo!'),
            };
        }
    }

    private function group(): void
    {
        $name = $this->ask('digite seu nome');
        $theme = $this->ask('Qual vai ser o tema do amigo secreto');
        $request = new Request(['name' => $theme]);
        $response = $this->groupsController->store($request);
        $data = $response->getData(true);
        $request = new Request(['name' => $name]);
        $this->groupsController->storeParticipant($request, $data['data']['id']);
        $this->info("Este é seu link do grupo: {$data['data']['id']}");
        $this->logout = $this->choice(PHP_EOL . 'Deseja sair?',['sim','nao']);
    }

    private function join(): void
    {
        $choice = $this->choice('Deseja entrar em um grupo, ou fazer o sorteio?',['entrar','sortear','amigo secreto']);
        switch ($choice) {
            case 'entrar':
                $name = $this->ask('digite seu nome');
                $code = $this->ask('Selecione o codigo do seu grupo');
                $request = new Request(['name' => $name]);
                $message = $this->groupsController->storeParticipant($request, $code);
                $data = $message->getData(true);
                $this->info($data['message']);
                break;

            case 'sortear':
                $code = $this->ask('Selecione o codigo do seu grupo');
                $this->assignSecretFriend($code);
                break;

            case 'amigo secreto':
                $set_name = $this->ask('Selecione seu nome');
                $code_group = $this->ask('Selecione o codigo do grupo');
                $this->getSecretFriend($set_name, $code_group);
        }

        $this->logout = $this->choice(PHP_EOL . 'Deseja sair?',['sim','nao']);
    }

    private function assignSecretFriend(string $code): void
    {
        $message = $this->groupsController->createSecretSantaMatches($code);
        $data = $message->getData(true);
        $this->info($data['message']);
    }

    private function getSecretFriend(string $name, string $code): void
    {
        $participantID = Participants::query()->where('group_id',$code)->where("name",$name)->firstOrFail();
        $friend = $this->groupsController->getParticipantGiftReceiver($code,$participantID->id);
        $data = $friend->getData(true);
        $this->info($data['data']['name']);
    }
}
