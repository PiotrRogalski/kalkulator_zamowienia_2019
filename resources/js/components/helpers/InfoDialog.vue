<template>
  <div class="text-xs-center">
    <v-dialog v-model="dialog" width="500">

      <template v-slot:activator="{ on }"><v-btn icon v-on="on"><v-icon>info</v-icon></v-btn></template>
      <v-card>
        <v-toolbar color="info" dark dense>
          <v-toolbar-title>Informacja</v-toolbar-title>
        </v-toolbar>

        <v-card-text><h4>{{message}}</h4></v-card-text>

        <v-card-actions>
          <v-btn color="primary" block flat class="mt-0" @click="dialog = false">Ok</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
  export default {
    props: ['message'],
    data () {
      return {
        dialog: false
      }
    }
  }
</script>
