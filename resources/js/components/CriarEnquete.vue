<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Nova Enquete</div>

          <div class="card-body">   
            <form>
              <div class="mb-3">
                <label for="nome_enquete" class="form-label"
                  >Nomeie sua Enquete</label
                >
                <input
                  type="text"
                  class="form-control"
                  id="nome_enquete"
                  required
                />
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
             
             
              <button @click.prevent="criarEnquete" type="submit" class="btn btn-primary">Criar Enquete</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    data(){
        return{
            nome_enquete: '',
            alternativa_1: '',
            alternativa_2: '',

        }
    },
  mounted() {
    console.log("Component mounted.");
  },
  methods: {
      criarEnquete(){
          axios.post('nova_enquete', {
            nome_enquete: this.nome_enquete,
            alternativa_1: this.alternativa_1,
            alternativa_2: this.alternativa_2,
          }).then(response=>console.log(response));
      }
  }
}
</script>
