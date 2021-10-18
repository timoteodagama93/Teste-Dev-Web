<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Minhas Enquetes</div>

          <div class="card-body">
            <ol class="list-group list-group-numbered">
              <li
                class="
                  list-group-item
                  d-flex
                  justify-content-between
                  align-items-start
                "
              >
                <div class="ms-2 me-auto">
                  <div class="fw-bold">Nome da enquete</div>
                  Cras justo odio
                </div>
                <span class="badge bg-primary rounded-pill">14</span>
              </li>

            </ol>
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
      
    };
  },
  mounted() {
    console.log("Componente montado.");
  },
  methods: {
    mostrarEnquetes() {
      alert("Enquete criada");
    },
  },
};
</script>
