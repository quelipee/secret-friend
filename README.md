# Amigo Secreto API

Um sistema para organizar e gerenciar amigos secretos de forma simples e eficiente.

## **Índice**
- [Instalação](#instalação)
- [Como Usar](#como-usar)
    - [Endpoints da API](#endpoints-da-api)
    - [Comando Artisan Interativo](#comando-artisan-interativo)


---

## **Instalação**

1. Clone o repositório:
   ```bash
   git clone https://github.com/quelipee/secret-friend.git
   cd secret-friend
   
2. Instale as dependências:
   ```bash
   composer install
   npm install
   
3. Configure as variáveis do banco de dados e outras conforme necessário.
4. Configure o banco de dados:
   ```bash
   php artisan migrate
   
## **Como Usar**
### **Endpoints da API**
1. Criar Grupo
   -  ```POST /api/groups```
   - Parâmetros:
       ```bash
        {
            "name": "Natal em Família"
        }
        ```
   - Resposta:
        ```bash
        {
            "message": "Group added successfully",
            "data": {
            "id": "9d8930fc-1eaa-46ce-9e07-357fa38405a0",
            "name": "Natal em Família"
          }
        }
        ```
2. Adicionar Participante
   - Rota: POST ```/api/groups/{groupId}/participants```
   -  Parâmetros:
      ````bash
      {
        "name": "João"
      }
      ````
   - Resposta:
     ````bash
     {
      "message": "Participant added successfully",
      "data": {
      "id": "34f8903f-123b-49e9-8c2b-58eeb73a2d9e",
      "name": "João"
      }
     }
     ````  
3. Gerar Pares
   - Rota: POST ````/api/groups/{groupId}/generate-matches````
   - Resposta:
      ````bash
       {
         "message": "Match found",
         "data": {
         "giver_id": "34f8903f-123b-49e9-8c2b-58eeb73a2d9e",
         "receiver_id": "45f8903f-222b-48e9-8d4c-67aeb54b2c8f"
          }
       }
      ````
## **Comando Artisan Interativo**
1. Execute o comando:
    ````bash
    php artisan generate:secret-santa
    ````
2. Siga as instruções interativas:
    - Digite seu nome.
    - Escolha criar ou entrar em um grupo.
    - Preencha os detalhes necessários, como nome do grupo e tema.

