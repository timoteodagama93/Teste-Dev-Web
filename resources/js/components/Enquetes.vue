
<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12" v-show="!respondendo">
        <div class="card">
          <div class="card-header">Enquetes</div>

          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nome da Enqueta</th>
                  <th scope="col">Acções</th>
                </tr>
              </thead>
              <tbody
                v-for="(enquete, index) in enquetes.data"
                :key="enquete.id"
              >
                <tr>
                  <th scope="row">{{ index + 1 }}</th>
                  <td>
                    {{ enquete.nome }} <br />Aos {{ enquete.created_at }}<br />
                    Tentativas:
                    <span class="badge bg-primary rounded-pill">{{
                      enquete.tentativas
                    }}</span>
                    <br />
                    Erros:
                    <span class="badge bg-primary rounded-pill">{{
                      enquete.erros
                    }}</span>
                    <br />
                    Acertos:
                    <span class="badge bg-primary rounded-pill">{{
                      enquete.acertos
                    }}</span>
                  </td>

                  <td>
                    <!-- Button trigger modal -->
                    <button
                      type="button"
                      class="btn btn-primary"
                      @click="responderEnquete(enquete.id)"
                      id="myBtn"
                    >
                      Responder
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>

            <pagination :data="enquetes">
              <span slot="prev-nav">&lt; Voltar</span>
              <span slot="next-nav">Próxima &gt;</span>
            </pagination>
          </div>
        </div>
      </div>

      <div class="col-md-12" v-show="respondendo">
        <div class="card">
          <div class="card-header">Respondendo a uma enquete</div>
          <div class="card-body" v-show="!mostrar_mensagem">
            <form>
              <div class="mb-3">
                <h3 class="form-label">{{ responder__nome_enquete }}</h3>
              </div>

              <table class="table">
                <tbody
                  v-for="(resposta, index) in respostas"
                  :key="resposta.id"
                >
                  <tr>
                    <th scope="row">{{ index + 1 }}</th>
                    <td>
                      {{ resposta.alternativa }} <br />
                      <span class="badge bg-primary">
                        Aos
                        {{ resposta.created_at }}
                      </span>
                    </td>
                    <td>
                      <div class="mb-3">
                        <input
                          type="radio"
                          v-model="resposta_usuario"
                          :value="index + 1"
                        />
                        <label>Marcar </label>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>

              <hr />

              <button
                @click.prevent="enviarResposta"
                type="submit"
                class="text-center btn btn-primary"
              >
                Enviar resposta
              </button>
              <button
                @click.prevent="cancelar"
                type="submit"
                class="text-center btn btn-secondary"
              >
                Cancelar
              </button>
            </form>
          </div>
          <div class="card-body" v-show="mostrar_mensagem">
            <div v-show="mostrar_mensagem_parabens">
              <h1>Parabéns você respondeu correctamente a enquete!!!</h1>

              <h3 class="text-center">Estatísticas da enquete</h3>

              <div class="progress">
                <div
                  class="progress-bar bg-success"
                  role="progressbar"
                  :style="'width:' + responder__num_acertos + '%'"
                  :aria-valuenow="responder__num_acertos"
                  aria-valuemin="1"
                  :aria-valuemax="responder__num_tentativa"
                >
                  {{ responder__num_acertos }}% de Acertos
                </div>
              </div>
              <hr />
              <div class="progress">
                <div
                  class="progress-bar bg-danger"
                  role="progressbar"
                  :style="'width:' + responder__num_erros + '%'"
                  :aria-valuenow="responder__num_erros"
                  aria-valuemin="1"
                  :aria-valuemax="responder__num_tentativa"
                >
                  {{ responder__num_erros }}% de Erros
                </div>
              </div>
            </div>
            <div v-show="mostrar_mensagem_infelici">
              <h1>
                Lamento, você não respondeu correctamente a enquete.<br />
                Mais sorte da próxima.
              </h1>
              <h3 class="text-center">Estatísticas da enquete</h3>

              <div class="progress">
                <div
                  class="progress-bar bg-success"
                  role="progressbar"
                  :style="'width:' + responder__num_acertos + '%'"
                  :aria-valuenow="responder__num_acertos"
                  aria-valuemin="1"
                  :aria-valuemax="responder__num_tentativa"
                >
                  {{ responder__num_acertos }}% de Acertos
                </div>
              </div>
              <hr />
              <div class="progress">
                <div
                  class="progress-bar bg-danger"
                  role="progressbar"
                  :style="'width:' + responder__num_erros + '%'"
                  :aria-valuenow="responder__num_erros"
                  aria-valuemin="1"
                  :aria-valuemax="responder__num_tentativa"
                >
                  {{ responder__num_erros }}% de Erros
                </div>
              </div>
            </div>
            <button
              @click.prevent="cancelar"
              type="submit"
              class="text-center btn btn-secondary"
            >
              Terminar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      mostrar_mensagem: false,
      mostrar_mensagem_parabens: false,
      mostrar_mensagem_infelici: false,
      respondendo: false,
      nome_enquete: "",
      alternativa_1: "",
      alternativa_2: "",
      resposta: "",
      resposta_usuario: "",
      responder__resposta: "false",
      responder__enquete_id: "",
      responder__nome_enquete: "",
      responder__num_acertos: 0,
      responder__num_erros: 0,
      responder__num_tentativas: 0,
      responder__num_respostas: 0,
      enquetes: {},
      respostas: {},
    };
  },
  mounted() {
    console.log("Component mounted.");
    // Fetch initial results
    this.getResults();
  },
  methods: {
    //Enviando a resposta uma resposta
    enviarResposta() {
      axios
        .post("respondendo_enquete", {
          enquete_id: this.responder__enquete_id,
          opcao_respondida: this.resposta_usuario,
        })
        .then((response) => {
          let resultado = response.data;
          this.resposta_usuario = "";

          if (resultado == "resposta_certa") {
            this.mostrar_mensagem = true;
            this.mostrar_mensagem_parabens = true;
          } else {
            this.mostrar_mensagem = true;
            this.mostrar_mensagem_infelici = true;
          }
        });
    },

    //Terminando uma Enquete
    cancelar() {
      this.mostrar_mensagem = false;
      this.mostrar_mensagem_parabens = false;
      this.mostrar_mensagem_infelici = false;
      this.respondendo = false;
      this.resposta_usuario = "";
      this.responder__resposta = "false";
      this.responder__enquete_id = "";
      this.responder__nome_enquete = "";
      this.responder__num_respostas = 0;
      this.responder__num_acertos = 0;
      this.responder__num_erros = 0;
      this.responder__num_tentativas = 0;
      this.getResults();
    },
    // Our method to GET results from a Laravel endpoint
    getResults(page = 1) {
      axios.get("listar_enquetes?page=" + page).then((response) => {
        console.log(response.data);
        this.enquetes = response.data;
      });
    },

    //Obter as respostas da enquete
    getRespostas(enquete_id) {
      axios.get("respostas_enquete/" + enquete_id).then((response) => {
        this.respostas = response.data;
      });
    },

    //A responder a uma enquete
    responderEnquete(enquete_id) {
      this.respondendo = true;
      this.getRespostas(enquete_id);
      axios.get("editar_enquete/" + enquete_id).then((response) => {
        console.log(response.data.enquete);
        this.responder__nome_enquete = response.data.nome;
        this.responder__num_respostas = response.data.num_respostas;
        this.responder__enquete_id = enquete_id;

        this.responder__num_acertos = response.data.acertos * 10;
        this.responder__num_erros = response.data.erros * 10;
        this.responder__num_tentativas = response.data.tentativas * 10;
      });
    },
  },
};
</script>

