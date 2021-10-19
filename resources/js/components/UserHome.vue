<style>
/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0, 0, 0); /* Fallback color */
  background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 15% auto; /* 15% from the top and centered */
  padding: 20px;
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

/* The Close Button */
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
</style>
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

      <div class="col-md-7">
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
                      @click="showModal = false"
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

      <div class="col-md-5" v-show="editando">
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
              <div class="mb-3" v-for="(resposta, index) in respostas.data"
                :key="resposta.id"
              >
                <label for="alternativa_1" class="form-label"
                  >{{index+1}}ª Alternativa</label
                >
                <input
                  type="text"
                  class="form-control"
                  value="{respostas}}"
                />
                 <label for="" class="form-label"
                  >Marcar a alternativa como a resposta</label>
                <input
                  type="radio"
                  id="one"
                  value="1"
                  v-model="editar__resposta"
                />
                <br/>
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
      editar__nome_enquete: "",
      editar__alternativa_1: "",
      editar__alternativa_2: "",
      editar__resposta: "",
      editar__num_respostas: 0,
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
    //Editando
    editarEnquete(enquete_id) {
      this.editando = true;
      axios.get("editar_enquete/" + enquete_id).then((response) => {
        console.log(response.data.enquete);
        this.editar__nome_enquete = response.data.nome;
        this.editar__num_respostas = response.data.num_respostas;
        axios.get("respostas_enquete/" + enquete_id).then((response) => {
          this.respostas = response.data[0];
        });
      });
    },
    // Our method to GET results from a Laravel endpoint
    getResults(page = 1) {
      axios.get("user_enquetes?page=" + page).then((response) => {
        console.log(response.data);
        this.enquetes = response.data;
        // Fetch initial results
        this.getResults();
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

