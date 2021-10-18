<template>
  <div class="container">
    <div class="row justify-content-center">

      <div class="col-md-12">
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
                      @click="criando = false"
                    >
                      Responder Enquete
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
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      criando: true,
      nome_enquete: "",
      alternativa_1: "",
      alternativa_2: "",
      resposta: "",
      enquetes: {},
    };
  },
  mounted() {
    console.log("Component mounted.");
    // Fetch initial results
    this.getResults();
  },
  methods: {
    //Editando

    editarEnquete() {
      this.criando = false;
    },
    // Our method to GET results from a Laravel endpoint
    getResults(page = 1) {
      axios.get("listar_enquetes?page=" + page).then((response) => {
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

