<template>
  <div class="container col-md-6 mt-5">
    <h2>Login</h2>
    <br>
    <form @submit.prevent="submit">
      <div class="form-group">
        <label>Email address</label>
        <input v-model.trim="form.email" type="email" class="form-control" placeholder="Enter email" autofocus>
        <small class="form-text text-danger" v-if="errors.email">{{ errors.email[0]}}</small>
      </div>
      <div class="form-group">
        <label >Password</label>
        <input v-model.trim="form.password" type="password" class="form-control" placeholder="Password">
        <small class="form-text text-danger" v-if="errors.password">{{ errors.password[0]}}</small>
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <br>
    <p>Dont have an account? <nuxt-link to="/register" class="">Register</nuxt-link></p>
    <p><nuxt-link to="/password/forgot" class="text-danger">Forgot Password</nuxt-link></p>
  </div>
</template>

<script>
export default {
  middleware: ["guest"],
  data() {
    return {
      form: {
        email: '',
        password: ''
      }
    }
  },
  methods: {
     submit() {
       this.$auth.loginWith("local", { // local se refiere a la strategie
          data: this.form
        }).then(data => {
          console.log(data);
          this.$router.push({ // por si habia intentado entrar a otra
            path: this.$route.query.redirect || "/dashboard"
          })
        }).catch(err => {
          console.log(err);
        });

    }
  }
}
</script>

