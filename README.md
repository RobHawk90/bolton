# Bolton App

Uma aplicação PHP que guarda as notas fiscais e disponibiliza o valor total delas para consulta via API Rest.

## Instalação

Você pode usar o [Git](https://git-scm.com/) para baixar os arquivos do projeto utilizando o comando:

```bash
git clone https://github.com/RobHawk90/bolton-challenge.git
```
É possível utilizar o ```make``` para baixar as imagens do [Docker](https://www.docker.com/) e construir os containers da aplicação, utilizando o comando:

```bash
make start
```
Copie ou renomeie o arquivo ```.env.example``` para ```.env``` dentro da pasta ```bolton > src``` e coloque as informações da [API](https://docs.arquivei.com.br/?urls.primaryName=Arquivei%20API#/nfe/get_v1_nfe_received) neste arquivo:

```
.env

...
23 ARQUIVEI_API_ID=<INSERT YOUR API ID HERE>
24 ARQUIVEI_API_KEY=<INSERT YOUR API KEY HERE>
```

Com o ```make``` é possível rodar o deploy da aplicação. Esse comando irá executar o passo a passo para a instalação completa da applicação a partir do script sh localizado em ```bolton/src/scripts/deploy.sh```:

```bash
make deploy
```

#### >>> Siga as instruções do deploy. <<<

Se tudo deu certo, será possível ver os testes passando após executar o seguinte comando:

```
make test
```

#### Observações
- Note que a aplicação é exposta em ```localhost:8080```
- Caso seja necessário trocar as portas dos containers, verifique o arquivo ```bolton/docker_bolton/docker-compose.yml```

## Uso

Após concluir o deploy, todas as NF-e fornecidas pela [API](https://docs.arquivei.com.br/?urls.primaryName=Arquivei%20API#/nfe/get_v1_nfe_received) da [Arquivei](https://arquivei.com.br/) estarão disponíveis para consulta.

Exemplo prático utilizando o [curl](https://curl.haxx.se/):

Request:
```bash
curl -X GET \
  http://localhost:8080/api/nfe/52170730290824000104550010000007391094809677 \
```
Response:
```json
{"data":{"key":"52170730290824000104550010000007391094809677","value":"753.5"}}
```

## License
[MIT](https://choosealicense.com/licenses/mit/)