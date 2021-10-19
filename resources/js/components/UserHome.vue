
<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5" v-show="!editando">
        <div class="card">
          <div class="card-header">Crie sua nova Enquete</div>

          <div class="card-body">
            <form>
              <div class="mb-3">
                <label for="nome_enquete" class="form-label"
                  >Nomeie sua Enquete</label
                >
                <input
                  type="text"
                  v-model="nome_enquete"
                  class="form-control"
                  id="nome_enquete"
                  required
                />
                <div id="novaHelper" class="form-text">
                  Cada nova enquete deve ser criada com 2 alternativas, assim
                  que criares a enquete podes adicionar mais oito alternativas.
                </div>
              </div>
              <div class="mb-3">
                <label for="alternativa_1" class="form-label"
                  >Iª Alternativa</label
                >
                <input
                  type="text"
                  class="form-control"
                  id="alternativa_1"
                  v-model="alternativa_1"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="alternativa_2" class="form-label"
                  >IIª Alternativa</label
                >
                <input
                  type="text"
                  required
                  v-model="alternativa_2"
                  class="form-control"
                  id="alternativa_2"
                />
              </div>
              <div class="mb-3">
                <label for="" class="form-label"
                  >Escolha a resposta da enquete</label
                >
                <br />
                <input type="radio" id="one" value="1" v-model="resposta" />
                <label for="one">Iª Alternativa </label>
                <br />
                <input type="radio" id="two" value="2" v-model="resposta" />
                <label for="two">IIª Alternativa </label>
                <br />
              </div>

              <button
                @click.prevent="criarEnquete"
                type="submit"
                class="btn btn-primary"
              >
                Criar Enquete
              </button>
            </form>
          </div>
        </div>
      </div>

      <div class="col-md-7" v-show="!editando">
        <div class="card">
          <div class="card-header">Minhas Enquetes</div>

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
                    Tentativas de usuarios:
                    <span class="badge bg-primary rounded-pill">{{
                      enquete.tentativas
                    }}</span>
                  </td>

                  <td>
                    <!-- Button trigger modal -->
                    <button
                      type="button"
                      class="btn btn-primary"
                      @click="editarEnquete(enquete.id)"
                      id="myBtn"
                    >
                      Editar
                    </button>
                    <button
                      type="button"
                      class="btn btn-primary"
                      id="show-modal"
                      @click="apagarEnquete(enquete.id)"
                    >
                      Apagar
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

      <div class="col-md-8" v-show="editando">
        <div class="card">
          <div class="card-header">A editar a enquete</div>
          <div class="card-body">
            <form>
              <div class="mb-3">
                <label for="nome_enquete" class="form-label"
                  >Nome da enquete</label
                >
                <input
                  type="text"
                  v-model="editar__nome_enquete"
                  class="form-control"
                  id="nome_enquete"
                  required
                />
              </div>
              <div class="mb-3">
                <span
                  >Não é possível apagar todas as respostas, devem sobrar duas.
                  <br />
                  <hr />
                  Se a tua resposta estiver entre as apagadas, a resposta padrão
                  é a primeira alternativa.</span
                >
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
                      <button
                        type="button"
                        class="btn btn-primary"
                        @click="apagarResposta(resposta.id)"
                      >
                        Apagar
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="mb-3" v-show="mostrar_add_alternativa">
                <label for="alternativa_2" class="form-label"
                  >Adicionar nova resposta</label
                >
                <input
                  type="text"
                  class="form-control"
                  id="nova_alternativa"
                  v-model="nova_alternativa"
                  required
                />
              </div>
              <div class="mb-3">
                <input
                  type="radio"
                  id="one"
                  value="true"
                  v-model="editar__resposta"
                />
                <label for="one">Marcar a alternativa como a resposta </label>
              </div>
              <button
                @click.prevent="adicionarAlternativa"
                type="submit"
                class="btn btn-primary"
              >
                Salvar alternativa
              </button>

              <hr />

              <button
                @click.prevent="guardarEnquete"
                type="submit"
                class="text-center btn btn-primary"
              >
                Salvar edição da enquete
              </button>
              <button
                @click.prevent="cancelarEdicao"
                type="submit"
                class="text-center btn btn-secondary"
              >
                Cancelar edição e voltar
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
      editando: false,
      nome_enquete: "",
      alternativa_1: "",
      alternativa_2: "",
      resposta: "",
      editar__resposta: "false",
      editar__enquete_id: "",
      editar__nome_enquete: "",
      editar__num_respostas: 0,
      nova_alternativa: "",
      enquetes: {},
      respostas: {},
      mostrar_add_alternativa: true,
    };
  },
  mounted() {
    console.log("Component mounted.");
    // Fetch initial results
    this.getResults();
  },
  methods: {
    //Obter as respostas da enquete
    getRespostas(enquete_id) {
      axios.get("respostas_enquete/" + enquete_id).then((response) => {
        this.respostas = response.data;
      });
    },
    //Editando
    editarEnquete(enquete_id) {
      this.editando = true;
      this.editar__enquete_id = enquete_id;

      this.getRespostas(enquete_id);
      axios.get("editar_enquete/" + enquete_id).then((response) => {
        console.log(response.data.enquete);
        this.editar__nome_enquete = response.data.nome;
        this.editar__num_respostas = response.data.num_respostas;
        if (this.editar__num_respostas === 10)
          this.mostrar_add_alternativa = false;
      });
    },
    //Cancelar a edição da enquete
    cancelarEdicao() { 
      this.editar__enquete_id = "";
      this.editar__nome_enquete = "";
      this.nova_alternativa = "";
      this.editar__num_respostas = 0;
      this.editando = false;
      this.respostas = {};
    },
    //Guardando a edição da enquete
    guardarEnquete() {
      axios
        .post("guardar_enquete", {
          enquete_id: this.editar__enquete_id,
          nome_enquete: this.editar__nome_enquete,
        })
        .then((response) => {
          console.log(response);

          this.editando = false;

          this.editar__enquete_id = "";
          this.editar__nome_enquete = "";
          this.nova_alternativa = "";
          this.editar__num_respostas = 0;
          this.getResults();
        });
    },
    //Apagar Enquete
    apagarEnquete(enquete_id) {
      axios.get("apagar_enquete/" + enquete_id).then((response) => {
        this.getRespostas(enquete_id);
      });
    },
    //Apagar Resposta
    apagarResposta(resposta_id) {
      axios.get("apagar_resposta/" + resposta_id).then((response) => {
        this.getRespostas(this.editar__enquete_id);
      });
    },
    // Our method to GET results from a Laravel endpoint
    getResults(page = 1) {
      axios.get("user_enquetes?page=" + page).then((response) => {
        console.log(response.data);
        this.enquetes = response.data;
      });
    },
    adicionarAlternativa() {
      console.log(this.editar__resposta);
      axios
        .post("nova_alternativa", {
          enquete_id: this.editar__enquete_id,
          num_respostas: this.editar__num_respostas,
          opcao_certa: this.editar__resposta,
          nova_alternativa: this.nova_alternativa,
        })
        .then((response) => {
          this.nova_alternativa = "";
          this.editar__resposta = "false";
          this.getRespostas(this.editar__enquete_id);
        });
    },
    criarEnquete() {
      axios
        .post("nova_enquete", {
          nome_enquete: this.nome_enquete,
          alternativa_1: this.alternativa_1,
          alternativa_2: this.alternativa_2,
          resposta: this.resposta,
        })
        .then((response) => {
          console.log(response);

          this.nome_enquete = "";
          this.alternativa_1 = "";
          this.alternativa_2 = "";
          this.resposta = "";
          this.getResults();
        });
    },
  },
};
</script>

