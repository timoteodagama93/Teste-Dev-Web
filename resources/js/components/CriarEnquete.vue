<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
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
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      nome_enquete: "",
      alternativa_1: "",
      alternativa_2: "",
      resposta: "",
    };
  },
  mounted() {
    console.log("Component mounted.");
  },
  methods: {
    getResults(page = 1) {
      axios.get("listar_enquetes?page=" + page).then((response) => {
        console.log(response.data);
        this.enquetes = response.data;
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
        .then(
          (response) => console.log(response)
          // Our method to GET results from a Laravel endpoint

          
        );
    },
  },
};
</script>
