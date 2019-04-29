<template>
  <div class="text-xs-center">
    <v-dialog
      v-model="dialog"
      width="500"
    >

      <template v-slot:activator="{ on }">
        <v-btn icon v-on="on"><v-icon>info</v-icon></v-btn>
      </template>

      <v-card>
        <v-card-title
          class="headline grey lighten-2"
          primary-title
        >
          Informacja
        </v-card-title>

        <v-card-text>
            {{message}}
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            flat
            @click="dialog = false"
          >
            Ok
          </v-btn>
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
