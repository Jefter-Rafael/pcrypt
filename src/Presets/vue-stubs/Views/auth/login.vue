<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <!-- {{ __("Login") }} -->
            Login
          </div>

          <div class="card-body">
            <form method="POST" action="" @submit.prevent="login">
              <!-- {{ route('login') }} -->
              <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">
                  <!-- {{ __("Email Address") }} -->
                  endereço de Emaill
                </label>

                <div class="col-md-6">
                  <input
                    id="email"
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    name="email"
                    required
                    autocomplete="email"
                    autofocus
                    v-model="email"
                  />
                  <!-- value="{{ old('email') }}" -->

                  <span class="invalid-feedback" role="alert">
                    <!-- <strong>{{ $message }}</strong> -->
                  </span>
                </div>
              </div>

              <div class="row mb-3">
                <label
                  for="password"
                  class="col-md-4 col-form-label text-md-end"
                  ><!--{{ __('Password') }}-->password</label
                >

                <div class="col-md-6">
                  <input
                    id="password"
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password"
                    required
                    v-model="password"
                    autocomplete="current-password"
                  />

                  <span class="invalid-feedback" role="alert">
                    <!-- <strong>{{ $message }}</strong> -->
                  </span>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6 offset-md-4">
                  <div class="form-check">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      name="remember"
                      id="remember"
                    />
                    <!-- {{ old("remember") ? "checked" : "" }} -->

                    <label class="form-check-label" for="remember">
                      <!-- {{ __('Remember Me') }} -->
                    </label>
                  </div>
                </div>
              </div>

              <div class="row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    <!-- {{ __('Login') }} -->
                  </button>

                  <a class="btn btn-link" href="">
                    <!-- {{ route('password.request') }} -->
                    <!-- {{ __('Forgot Your Password?') }} -->
                  </a>
                </div>
              </div>
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
      email:'jefterrafael1.1@gmail.com',
      password:'985541456',
    };
  },
  beforeCreate() {
    /****
     * beforeCreateé o primeiro gancho de ciclo de vida que é chamado no Vue JS. beforeCreateé chamado logo após uma nova instância do Vue ser inicializada. Aqui, as propriedades calculadas, observadores, eventos, propriedades de dados, etc., não são configuradas.
     ****/
  },
  created() {
    /****
     * createdé o próximo gancho de ciclo de vida que é chamado após o beforeCreategancho. Aqui, as propriedades computadas, observadores, eventos, propriedades de dados, etc., também são ativados.
     * Poderemos acessar as propriedades de dados que não estavam acessíveis no hook anterior.
     ****/
  },
  beforeMount() {
    /****
     * beforeMounté o próximo gancho de ciclo de vida que é chamado após o createdgancho e logo antes da instância do Vue ser montada no DOM. O modelo e os estilos são todos compilados aqui, mas o DOM ainda não pode ser manipulado.
     ****/
  },
  mounted() {
    /****
     * mountedé o próximo gancho de ciclo de vida que é chamado após o beforeMountgancho e logo após a instância do Vue ter sido montada. O componente de aplicativo ou qualquer outro componente torna-se funcional e está pronto para uso.
     ****/
  },
  beforeUpdate() {
    /****
     * beforeUpdateé o próximo gancho de ciclo de vida chamado após o gancho montado. beforeUpdateé chamado sempre que uma alteração é feita nos dados que requerem a atualização do DOM.
     ****/
  },
  updated() {
    /****
     * updatedé o próximo gancho do ciclo de vida. updatedé chamado após o beforeUpdategancho e logo após a atualização do DOM.
     ****/
  },
  beforeDestroy() {
    /****
     * O beforeDestroygancho é chamado logo antes de uma instância do Vue ser destruída. A instância e todos os métodos ainda estão funcionais. Podemos fazer o gerenciamento de recursos aqui.
     ****/
  },
  destroyed() {
    /****
     * destroyedé o gancho do ciclo de vida do último estágio, onde toda a instância do Vue é destruída. Event listeners, mixins e todas as diretivas ficam ilimitadas aqui.
     ****/
  },
  computed() {},
  methods: {
    login() {
      const self = this;
      axios
        .post("/login", {
          email: "jefterrafael1.1@gmail.com",
          password: "985541456",
        })
        .then((s) => {
          console.log(s);
          self.$store.state.user = s.data.name
          console.log(self.$store.state.user)
          if(s.status == 200){
            self.$router.push('/home')
          }
        })
        .catch((e) => {
          console.log(e);
        });
    },
  },
};
</script>

<style>
</style>