
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
                    Score:
                    <span class="badge bg-primary rounded-pill">{{
                      enquete.tentativas
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
          <div class="card-header">A editar a enquete</div>
          <div class="card-body">
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
                        <input type="radio" v-on="selecionarResposta(index+1)" />
                        <label >Marcar </label>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>

              <hr />

              <button
                @click.prevent="guardarEnquete"
                type="submit"
                class="text-center btn btn-primary"
              >
                Enviar resposta
              </button>
              <button
                @click.prevent="cancelarEdicao"
                type="submit"
                class="text-center btn btn-secondary"
              >
                Cancelar
              </button>
            </form>
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
      respondendo: false,
      nome_enquete: "",
      alternativa_1: "",
      alternativa_2: "",
      resposta: "",
      responder__resposta: "false",
      responder__enquete_id: "",
      responder__nome_enquete: "",
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

    //Selecionando uma resposta
    selecionarResposta(opcao_numero){
      this.resposta = opcao_numero;
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
      });
    },
  },
};
</script>

