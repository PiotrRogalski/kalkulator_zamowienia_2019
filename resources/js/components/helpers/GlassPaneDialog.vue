<template>
<v-layout row justify-center>
<v-dialog v-model="isDialogOpen" width="600px" persistent>
<v-card>
  <v-toolbar color="blue-grey" dark dense>
    <v-toolbar-title>{{ formTitle }}</v-toolbar-title>
    <v-spacer></v-spacer>
    <v-btn icon flat dark @click="closeDialog"><v-icon>close</v-icon></v-btn>
  </v-toolbar>
  <v-card-text pa-2>
      <h4>Rodzaj szkła</h4>
      <v-layout>
          <v-flex xs12 md5 px-2><v-select label="Materiał" :items="materials" :disabled="materials.length <= 0" item-text="name"
              item-value="id" prepend-icon="terrain" @change="choosedMaterialId" :value="materials[0]"></v-select></v-flex>
          <v-flex xs12 md4 px-2>
            <v-select label="Typ" :items="materialTypes"  :disabled="materialTypes.length <= 1" item-text="name" prepend-icon="crop_original"
              item-value="id" @change="choosedMaterialTypeId" :value="materialTypes[0]"></v-select></v-flex>
          <v-flex xs12 md3 px-2 v-if="glassMarks <= 0">
            <v-select label="Grubość" :items="thickness" item-text="name" :disabled="thickness.length <= 1"
              append-icon="vertical_align_center" @change="choosedThicknessName" :value="thickness[0]"
            ></v-select></v-flex>
          <v-flex xs12 md3 px-2 v-else>
            <v-select label="Oznaczenie" :items="glassMarks" item-text="name" :disabled="glassMarks.length <= 1"
              append-icon="description" @change="choosedGlassMarksName" :value="glassMarks[0]"
            ></v-select></v-flex>
      </v-layout>
      <h4>Wymiary tafli</h4>
      <v-layout align-center justify-space-around row>
        <v-flex px-3 xs12 md5><v-text-field label="Szerokość" suffix="cm" prepend-icon="code" v-model="glassPaneWidth"
              @change="choosedGlassPaneWidth"></v-text-field></v-flex>
        <v-btn flat disabled fab small><v-icon dark>clear</v-icon></v-btn>
        <v-flex px-3 xs12 md5><v-text-field label="Wysokość" suffix="cm" prepend-icon="unfold_more" v-model="glassPaneHeight"
              @change="choosedGlassPaneHeight"></v-text-field></v-flex>
        <p v-if="(glassPaneWidth*1 !== 0 && glassPaneHeight*1 !== 0)">Powierzchnia: {{ areaInSquareMeters }}</p>
      </v-layout>
      <h4>Rodzaj szlifu</h4>
      <v-layout>
        <v-flex xs12>
          <v-select label="Nazwa" prepend-icon="tune" :items="cutModels" item-value="id" item-text="name"
                    @change="choosedCutModelId"  :value="cutModels[0]" :disabled="cutModels.length <= 1"
          ></v-select>
        </v-flex>
      </v-layout>

    <v-btn block color="info" dark @click="addHole">DODAJ OTWORY</v-btn>
    <v-card v-if="holes.length > 0"><v-card-text>
      <v-layout align-start justify-start row v-for="(item, key) in holes" :key="key">
      <v-flex px-3 xs5><v-text-field label="Średnica" suffix="mm" prepend-icon="block" v-model="holes[key].diameter"
             @change="changeTotalValueInPenny"></v-text-field></v-flex>
      <v-flex px-3 xs5><v-text-field label="Ilość" suffix="szt" prepend-icon="filter_none" v-model="holes[key].number"
             @change="changeTotalValueInPenny"></v-text-field></v-flex>
      <v-flex><v-btn flat fab @click="deleteHole(item)"><v-icon>close</v-icon></v-btn></v-flex>
    </v-layout>
    </v-card-text></v-card>

    <v-btn block color="orange darken-1" dark @click="addService">DODAJ USŁUGI</v-btn>
    <v-card v-if="services.length > 0"><v-card-text>
      <v-layout align-start justify-start row v-for="(item, key) in services" :key="key">
      <v-flex px-3 xs6><v-select label="Nazwa" :items="servicesList" item-text="name" item-value="id" v-model="services[key].service_list_id"
             @change="changeTotalValueInPenny"></v-select></v-flex>
      <v-flex px-3 xs4><v-text-field label="Ilość" :suffix="serviceUnit(services[key].service_list_id)" v-model="services[key].quantity"
             @change="changeTotalValueInPenny" prepend-icon="filter_none"></v-text-field></v-flex>
      <v-flex><v-btn flat fab @click="deleteService(item)"><v-icon>close</v-icon></v-btn></v-flex>
    </v-layout>
    </v-card-text></v-card>

    <v-btn block color="orange darken-4" dark @click="addAdditionalService">DODAJ DODATKOWE USŁUGI</v-btn>
    <v-card v-if="additionalServices.length > 0"><v-card-text>
      <v-layout align-start justify-start row wrap v-for="(item, key) in additionalServices" :key="key">
        <v-flex px-3 xs6><v-text-field label="Cena" suffix="zł" v-model="additionalServices[key].price" prepend-icon="attach_money"
               @change="changeTotalValueInPenny"></v-text-field></v-flex>
        <v-flex><v-btn flat fab @click="deleteAdditionalService(item)"><v-icon>close</v-icon></v-btn></v-flex>
        <v-flex px-3 xs12><v-textarea box name="additional-service-body" label="Opis" v-model="additionalServices[key].description"></v-textarea></v-flex>
    </v-layout>
    </v-card-text></v-card>

    <h4 class="mt-4">Ilość sztuk tego produktu</h4>
    <v-layout align-center justify-space-around row>
      <v-flex px-3 xs12><v-text-field label="Ilość" suffix="szt" prepend-icon="scatter_plot" v-model="glassPaneQuantity"
            @change="changeTotalValueInPenny"></v-text-field></v-flex>
    </v-layout>

    <h2>Cena produktu: {{ totalValueInPennyShowed }}</h2>
    <p v-if="(glassPaneWidth*1 === 0 || glassPaneHeight*1 === 0)" class="red--text">
      Uzupełnij wysokość i szerokość tafli!
    </p>
  </v-card-text>
  <v-card-actions v-if="(glassPaneWidth*1 === 0 || glassPaneHeight*1 === 0)">
    <v-btn block color="amber darken-4" flat dark @click="closeDialog">Anuluj</v-btn>
  </v-card-actions>
  <v-card-actions v-else>
    <v-btn color="amber darken-4" flat dark @click="closeDialog">Anuluj</v-btn>
    <v-spacer></v-spacer>
    <v-btn color="green darken-1" dark @click="saveDialog">Zapisz</v-btn>
  </v-card-actions>
</v-card>
</v-dialog>
</v-layout>
</template>
<script>
  export default {
    data () {return {
      isDialogOpen: false,
      materials: [], materialTypes: [], thickness: [], cutModels: [], glassModels: [], glassMarks: [],
      holes: [], additionalServices: [], services: [],
      totalValueInPennyShowed: '0 zł', totalValueInPenny: 0, index: -1,
      glassPaneQuantity: 0, glassPaneWidth: 0, glassPaneHeight: 0, areaInSquareMeters: '0 m2',
      choosenMaterialId: 1, choosenMaterialTypeId: -1, choosenThicknessName: null, choosenGlassMarksName: null,
      choosenGlassModelId: -1, choosenGlassModelName: null, choosenCutModelId: -1,
      choosenCutModelId: -1,
      allMaterialTypes: [], allCutModels: [], holePrices: [], servicesList: [],
      unitGlassDimension: 'cm',
    }},
    created() {
      this.getMaterials();
      this.getMaterialTypes();
      this.getGlassModels();
      this.getCutModels();
      this.getServicesList();
      this.getHolePrices();
      this.lisen();
    },
    computed: {
      formTitle () {return nd2.isEmpty(this.obj) ? 'Dodaj produkt' : 'Edytuj produkt'},
    },
    methods: {
      lisen(){
        EventBus.$on('openAddGlassPaneDialog', () => {this.isDialogOpen = true;});
        EventBus.$on('closeAddGlassPaneDialog', () => {this.resetVariables(); this.isDialogOpen = false;});
        EventBus.$on('openToEditGlassPaneDialog', (obj) => {this.assignGlassPaneObjectToEditing(obj);});
      },
      closeDialog(){EventBus.$emit('closeAddGlassPaneDialog');},
      saveDialog(){this.emitGlassPaneObj(); this.closeDialog();},
      addHole() {let obj = {number: '', diameter: 1}; this.holes.push(obj); this.changeTotalValueInPenny();},
      deleteHole(item) {let index = this.holes.indexOf(item); this.holes.splice(index, 1); this.changeTotalValueInPenny();},
      addService() {let obj = {service_list_id: '', quantity: ''}; this.services.push(obj);},
      deleteService(item) {let index = this.services.indexOf(item); this.services.splice(index, 1); this.changeTotalValueInPenny();},
      addAdditionalService() {let obj = {price: '', description: ''}; this.additionalServices.push(obj);},
      deleteAdditionalService(item) {let index = this.additionalServices.indexOf(item); this.additionalServices.splice(index, 1); this.changeTotalValueInPenny();},
      //Get from database
      getMaterials() {axios.get('/api/material/all').then(res =>  this.gettedMaterials(res.data)).catch(e => console.log(e));},
      getMaterialTypes() {axios.get('/api/material-types/all').then(res => this.gettedMaterialTypes(res.data)).catch(e => console.log(e));},
      getCutModels() {axios.get('/api/cut-models/all').then(res => this.gettedCutModels(res.data)).catch(e => console.log(e));},
      getGlassModels() {axios.get('/api/glass-models/all').then(res => this.gettedGlassModels(res.data)).catch(e => console.log(e));},
      getHolePrices() {axios.get('/api/hole-prices/all').then(res => this.holePrices = res.data).catch(e => console.log(e));},
      getServicesList() {axios.get('/api/services-list/all').then(res => this.servicesList = res.data).catch(e => console.log(e));},

      //Getters counted
      gettedMaterials(data) {this.materials = data;},
      gettedMaterialTypes(data) {
        this.allMaterialTypes = data;
        this.allMaterialTypes.unshift({id: null, name: 'Brak'});
      },
      gettedGlassModels(data) {
        this.glassModels = data;
        this.changeMaterialTypesList();
        this.changeGlassModelThicknessList();
        this.changeTotalValueInPenny();
      },
      gettedCutModels(data) {
        this.allCutModels = data;
        this.allCutModels.unshift({
          id: 0, name: 'Brak', material_id: null, material_type_id: null,
          thickness_from: null, thickness_to: null, unit: 'szt', price: 0, deleted_at: null
        });
        this.changeCutModelsList();
      },

      //Selectbox choosed options - what to do if i check smth
      choosedGlassPaneWidth(val) {this.getAreaInSquareMeters();this.changeTotalValueInPenny();},
      choosedGlassPaneHeight(val) {this.getAreaInSquareMeters();this.changeTotalValueInPenny();},
      choosedMaterialId(id){
        this.choosenMaterialId = id;
        this.changeMaterialTypesList();
        this.changeGlassModelGlassMarksList();
        this.changeGlassModelThicknessList();
        this.changeCutModelsList();
      },
      choosedMaterialTypeId(id){
        this.choosenMaterialTypeId = id;
        this.changeGlassModelGlassMarksList();
        this.changeGlassModelThicknessList();
        this.changeCutModelsList();
      },
      choosedThicknessName(name){
        this.choosenThicknessName = name;
        this.changeCutModelsList();
        this.changeGlassModelId();
      },
      choosedCutModelId(id){
        this.choosenCutModelId = id;
        this.changeTotalValueInPenny();
      },
      choosedGlassMarksName(name){
        this.choosenGlassMarksName = name;
        this.changeGlassModelThicknessList();
        this.changeCutModelsList();
      },

      //Changed options - update lists in selectboxes
      changeTotalValueInPennyShow() {
        let pennyPrice = Math.ceil(nd2.validNumber(this.totalValueInPenny));
        let pln = pennyPrice/100;
        this.totalValueInPennyShowed = nd2.validNumber(pln) + ' zł';
      },
      changeTotalValueInPenny() {
        let glassModelId = nd2.validNumber(this.choosenGlassModelId, 0, 1, true);
        let quantity = nd2.validNumber(this.glassPaneQuantity, 0, 1, true);
        let width = nd2.validNumber(this.glassPaneWidth, 0, 0);
        let height = nd2.validNumber(this.glassPaneHeight, 0, 0);
        let canCountGlassPanePrice = (width > 0 && height > 0 && glassModelId >= 0);
        let glassModelPrice = 0;
        let cutModelPrice = 0;
        let holesPrice = 0;
        let servicesPrice = 0;
        let additionalServicesPrice = 0;
        let sum = 0;
        if (quantity === 0) quantity = 1;

        this.glassPaneQuantity = quantity;
        this.glassPaneWidth = width;
        this.glassPaneHeight = height;

        if (canCountGlassPanePrice) {
          glassModelPrice = nd2.validNumber(this.countGlassModelPrice());
          cutModelPrice = nd2.validNumber(this.countCutModelPrice());
          holesPrice = nd2.validNumber(this.countHolesPrice());
          servicesPrice = nd2.validNumber(this.countServicesPrice());
          additionalServicesPrice = nd2.validNumber(this.countAdditionalServicesPrice());
          sum = glassModelPrice + cutModelPrice + holesPrice + servicesPrice + additionalServicesPrice;
          this.totalValueInPenny = sum * quantity;
        } else {
          this.totalValueInPenny = 0;
        }

        this.changeTotalValueInPennyShow();
      },

      changeGlassModelId(){
        let glassModelIds = [];
        this.choosenGlassModelId = -1;

        glassModelIds = this.getChoosedGlassModel(['id']);

        if (glassModelIds.length > 0) {
          this.choosenGlassModelId = nd2.validNumber(glassModelIds[0].id);
          this.changeCutModelsList();
          this.changeTotalValueInPenny();
        }
      },
      changeGlassModelGlassMarksList() {
        let data = this.glassModels.sort((a,b) => a.glass_mark - b.glass_mark);
        let materialId = nd2.validNumber(this.choosenMaterialId);
        let materialTypeId = nd2.validNumber(this.choosenMaterialTypeId);
        this.glassMarks = [];

        this.glassMarks = data.filter(function(obj) {
          let materialOK = (nd2.validNumber(obj.material_id) === nd2.validNumber(materialId));
          let materialTypeOK = (nd2.validNumber(obj.material_type_id) === nd2.validNumber(materialTypeId));
          let glassMarkOK = (obj.glass_mark != null);
          return (materialOK && materialTypeOK && glassMarkOK);
        }).map(function(obj) {return {name: obj.glass_mark}});

        if (this.glassMarks.length > 0) {
          this.choosenGlassMarksName = this.glassMarks[0].name;
        } else {this.choosenGlassMarksName = null;}
      },

      changeGlassModelThicknessList() {
        let data = this.glassModels.sort((a,b) => a.thickness - b.thickness);
        let materialId = nd2.validNumber(this.choosenMaterialId);
        let materialTypeId = nd2.validNumber(this.choosenMaterialTypeId);
        let glassMarkName = this.choosenGlassMarksName;
        this.thickness = [];

        this.thickness = data.filter(function(obj) {
          let materialOK = (nd2.validNumber(obj.material_id) === nd2.validNumber(materialId));
          let materialTypeOK = (nd2.validNumber(obj.material_type_id) === nd2.validNumber(materialTypeId));
          let glassMarkOK = (obj.glass_mark === glassMarkName);
          return (materialOK && materialTypeOK && glassMarkOK);
        }).map(function(obj) {return {name: nd2.validNumber(obj.thickness)/1000 + ' mm'}});

        if (this.thickness.length > 0) {
          this.choosenThicknessName = this.thickness[0].name;
          this.changeGlassModelId();
        } else {this.choosenThicknessName = null;}
      },

      changeMaterialTypesList() {
        let data = this.glassModels.sort((a,b) => a.material_type_id - b.material_type_id);
        if (data.length === 0) {return false;}
        let materialId = nd2.validNumber(this.choosenMaterialId);
        let materialTypeIds = [];
        this.materialTypes = [];


        materialTypeIds = data.filter(function(obj) {
          return (nd2.validNumber(obj.material_id) === nd2.validNumber(materialId)); })
          .map(function(obj) { let result = null;
            if (obj.material_type_id !== null) {result = nd2.validNumber(obj.material_type_id)}
            return result;
          });

        let materialTypesDistinctIds = [...new Set(materialTypeIds)];
        data = this.allMaterialTypes;

        for(let index in data) {
          if (materialTypesDistinctIds.indexOf(data[index].id) != -1) {
            let obj = {id: nd2.validNumber(data[index].id), name:data[index].name};
            this.materialTypes.push(obj);
          }
        }

        if (this.materialTypes.length > 0) {
          this.choosenMaterialTypeId = nd2.validNumber(this.materialTypes[0].id);
        } else {this.choosenMaterialTypeId = -1;}
      },

      changeCutModelsList() {
        let data = this.allCutModels.sort((a,b) => a.id - b.id);
        let materialId = nd2.validNumber(this.choosenMaterialId);
        let materialTypeId = nd2.validNumber(this.choosenMaterialTypeId);
        let thicknessName = this.choosenThicknessName;
        let thickness = 0;
          this.cutModels = [];

        let regexGetThickness = /\d+([,.])?(\d+)?/g;
        if (!nd2.empty(thicknessName)){
          thickness = nd2.validNumber(thicknessName.match(regexGetThickness)) * 1000;
        }

        this.cutModels = data.filter(function(obj) {
          let thickness_from = nd2.validNumber(obj.thickness_from);
          let thickness_to = nd2.validNumber(obj.thickness_to);
          let materialOK = ((obj.material_id == null) || (nd2.validNumber(obj.material_id) === nd2.validNumber(materialId)));
          let materialTypeOk = ((obj.material_type_id == null) || (nd2.validNumber(obj.material_type_id) === nd2.validNumber(materialTypeId)));
          let thicknessPart1OK = ((thickness_from <= thickness) && (thickness_to >= thickness));
          let thicknessPart2OK = ((thickness_from <= thickness) && (obj.thickness_to == null));
          let thicknessPart3OK = ((obj.thickness_from == null) && (thickness_to >= thickness));
          let thicknessPart4OK = ((obj.thickness_from == null) && (obj.thickness_to == null));
          let thicknessOk = (thicknessPart1OK || thicknessPart2OK || thicknessPart3OK || thicknessPart4OK);
          let result = (materialOK && materialTypeOk && thicknessOk);

          return result;
        }).map(function(obj) {return {id: nd2.validNumber(obj.id), name: obj.name}});

        if (this.cutModels.length > 0) {
          this.choosenCutModelId = nd2.validNumber(this.cutModels[0].id);
        } else {this.choosenCutModelId = -1;}
      },
      serviceUnit(id) {
        for(let item in this.servicesList) {
          if (nd2.validNumber(this.servicesList[item].id) === nd2.validNumber(id)) {return this.servicesList[item].unit;}
        }
        return '?';
      },
      getChoosedGlassModel(returnCompacts){
        let data = this.glassModels.sort((a,b) => a.id - b.id);
        let materialId = nd2.validNumber(this.choosenMaterialId);
        let materialTypeId = nd2.validNumber(this.choosenMaterialTypeId);
        let thicknessName = this.choosenThicknessName;
        let glassMarkName = this.choosenGlassMarksName;
        let val = returnCompacts;
        let rows = [];

        let regexGetThickness = /\d+([,.])?(\d+)?/g;
        let thickness = thicknessName.match(regexGetThickness) * 1000;

        rows = data.filter(function(obj) {
          let materialOK = (nd2.validNumber(obj.material_id) === nd2.validNumber(materialId));
          let materialTypeOK = (nd2.validNumber(obj.material_type_id) === nd2.validNumber(materialTypeId));
          let thicknessOK = (nd2.validNumber(obj.thickness) === nd2.validNumber(thickness));
          let glassMarkOK = (obj.glass_mark == glassMarkName);
          return (materialOK && materialTypeOK && thicknessOK && glassMarkOK);
        }).map(function(obj) {
          let object = {};
          for (let i in val) {object[val[i]] = obj[val[i]];}
          return object;
        });

        return rows;
      },
      getChoosedCutModel(returnCompacts){
        let data = this.allCutModels.sort((a,b) => a.id - b.id);
        let cutModelId = nd2.validNumber(this.choosenCutModelId);
        let val = returnCompacts;
        let rows = [];

        if (cutModelId === null) return false;

        rows = data.filter(function(obj) {
          return (nd2.validNumber(obj.id) === nd2.validNumber(cutModelId));
        }).map(function(obj) {
          let object = {};
          for (let i in val) {object[val[i]] = obj[val[i]];}
          return object;
        });

        return rows;
      },
      countGlassModelPrice(){
        let glassModelId = nd2.validNumber(this.choosenGlassModelId);
        let inputDimensionUnit = nd2.validNumber(this.unitGlassDimension);
        let width = nd2.validNumber(this.glassPaneWidth);
        let height = nd2.validNumber(this.glassPaneHeight);
        let glassModels = this.getChoosedGlassModel(['id','name','unit','price']);
        let glassModel = glassModels[0];
        let glassModelLoadedOk = (nd2.validNumber(glassModelId) === nd2.validNumber(glassModel.id));
        let glassModelIdNotZero = (glassModelId > 0);
        let canCount = (glassModelLoadedOk && glassModelIdNotZero);
        let price = 0;

        if (canCount) {
          let multi = this.priceUnitMultiplier(glassModel.unit, width, height, inputDimensionUnit);
          price = nd2.validNumber(glassModel.price) * nd2.validNumber(multi);
          this.choosenGlassModelName = glassModel.name;
        }
        return price*100;
      },
      countCutModelPrice(){
        let cutModelId = nd2.validNumber(this.choosenCutModelId);
        let inputDimensionUnit = nd2.validNumber(this.unitGlassDimension);
        let width = nd2.validNumber(this.glassPaneWidth);
        let height = nd2.validNumber(this.glassPaneHeight);
        let cutModels = this.getChoosedCutModel(['id', 'name', 'unit', 'price']);
        let cutModel = cutModels[0];
        let cutModelLoadedOk = (nd2.validNumber(cutModelId) === nd2.validNumber(cutModel.id));
        let cutModelIdNotZero = (cutModelId > 0);
        let canCount = (cutModelLoadedOk && cutModelIdNotZero);
        let price = 0;

        if (canCount) {
          let multi = this.priceUnitMultiplier(cutModel.unit, width, height, inputDimensionUnit);
          price = nd2.validNumber(cutModel.price) * nd2.validNumber(multi);
          this.choosenCutModelName = cutModel.name;

        }
        return price;
      },
      countHolesPrice(){
        let data = this.holePrices;
        let holes = this.holes;
        let len = holes.length;
        let price = 0;
        let singleHolePrice = 0;
        for(let i = 0; i < len; ++i) {
            let fi = nd2.validNumber(holes[i].diameter, 1, 1);
            let rows = data.filter(function(obj) {
              return (nd2.validNumber(obj.diameter_from) <= fi && nd2.validNumber(obj.diameter_to) >= fi);
            }).map(function(obj) {return {price: obj.price}});
            if (rows.length === 0) {return 0;}
            let row = rows[0];

            holes[i].diameter = nd2.validNumber(holes[i].diameter, 0, 1);
            holes[i].number = nd2.validNumber(holes[i].number, 1, 1, true);
            singleHolePrice = nd2.validNumber(row.price) * holes[i].number;

            holes[i].price = singleHolePrice;
            holes[i].unit = 'szt';
            price += singleHolePrice;
        }
        return price;
      },
      countServicesPrice(){
        let data = this.servicesList;
        let services = this.services;
        let len = services.length;
        let singleServicePrice = 0;
        let price = 0;
        for(let i = 0; i < len; ++i) {
            let rows = data.filter(function(obj) {
              return (nd2.validNumber(obj.id) === nd2.validNumber(services[i].service_list_id));
            }).map(function(obj) {return {price: obj.price, unit: obj.unit, name: obj.name}});
            if (rows.length === 0) {return false;}
            let row = rows[0];

            services[i].quantity = nd2.validNumber(services[i].quantity, 0, 1, true);
            singleServicePrice = nd2.validNumber(row.price) * services[i].quantity;

            services[i].price = singleServicePrice;
            services[i].unit = row.unit;
            services[i].name = row.name;

            price += singleServicePrice;
        }
        return price;
      },
      countAdditionalServicesPrice(){
        let additionalServices = this.additionalServices;
        let len = additionalServices.length;
        let price = 0;
        for(let i = 0; i < len; ++i) {
          price += nd2.validNumber(additionalServices[i].price);
          additionalServices[i].price = price;
        }
        return price*100;
      },
      priceUnitMultiplier(unit, width, height, dimensionsUnit){
        let w = nd2.validNumber(width);
        let h = nd2.validNumber(height);
        let multiplier = 0;
        let divider = 100;
        switch (dimensionsUnit) {
          case 'mm': divider = 1000; break;
          case 'cm': divider = 100; break;
        }

        switch (unit) {
          case 'szt': multiplier = 1; break;
          case 'm2': multiplier = w * h / (divider * divider); break;
          case 'mb': multiplier = (2*(w + h)) / divider; break;
        }
        return multiplier;
      },
      resetVariables() {
          this.holes = [];
          this.additionalServices = [];
          this.services = [];
          this.totalValueInPennyShowed = '0 zł';
          this.totalValueInPenny = 0;
          this.glassPaneQuantity ='';
          this.glassPaneWidth = '';
          this.glassPaneHeight = '';
          this.areaInSquareMeters = 0;
          this.index = -1;
      },
      getAreaInSquareMeters() {
        let width = nd2.validNumber(this.glassPaneWidth);
        let height = nd2.validNumber(this.glassPaneHeight);
        let unit = nd2.validNumber(this.unitGlassDimension);
        let areaInSquareMeters = 0;
        let divider = 100;

        if (width !== 0 && height !== 0) {
          switch (unit) {
            case 'mm': divider = 1000; break;
            case 'cm': divider = 100; break;
          }
          areaInSquareMeters =  (width*height) / (divider * divider);
        }
        this.areaInSquareMeters = nd2.validNumber(areaInSquareMeters) + ' m2';
      },
      emitGlassPaneObj() {
        let glassPaneObj = {};
        glassPaneObj.glass_model_id = this.choosenGlassModelId;
        if (nd2.validNumber(this.choosenGlassModelName) === 0 || nd2.validNumber(this.choosenGlassModelId) === -1) {
          glassPaneObj.glass_model_name = 'Brak';
        } else {
          glassPaneObj.glass_model_name = this.choosenGlassModelName;
        }
        glassPaneObj.width = nd2.validNumber(this.glassPaneWidth);
        glassPaneObj.height = nd2.validNumber(this.glassPaneHeight);
        glassPaneObj.cut_model_id = nd2.validNumber(this.choosenCutModelId);
        if (nd2.validNumber(this.choosenCutModelName) === 0 || nd2.validNumber(this.choosenCutModelId) === -1) {
          glassPaneObj.cut_model_name = 'Brak';
        } else {
          glassPaneObj.cut_model_name = this.choosenCutModelName;
        }
        if (nd2.validNumber(this.glassPaneQuantity) > 0) {glassPaneObj.quantity = nd2.validNumber(this.glassPaneQuantity);}
        else {glassPaneObj.quantity = 1;}
        glassPaneObj.price = nd2.validNumber(this.totalValueInPenny);

        //TODO  - zamienic puste stringi na (number) 1
        glassPaneObj.holes = this.cutValuesFromArray(this.holes, ['diameter']);
        glassPaneObj.services = this.cutValuesFromArray(this.services, ['service_list_id']);
        glassPaneObj.additionalServices = this.changeValueInArray(this.additionalServices, ['price'], 0);
        glassPaneObj.unitGlassPaneDimension = this.unitGlassDimension;
        glassPaneObj.index = this.index;

        // console.log(glassPaneObj);

        EventBus.$emit('addGlassPaneToProductsList', glassPaneObj);
      },
      assignGlassPaneObjectToEditing(obj) {
        this.holes = obj.holes;
        this.additionalServices = obj.additionalServices;
        this.services = obj.services;
        this.totalValueInPenny = nd2.validNumber(obj.price);
        this.glassPaneQuantity = nd2.validNumber(obj.quantity);
        this.glassPaneWidth = nd2.validNumber(obj.width);
        this.glassPaneHeight = nd2.validNumber(obj.height);
        this.index = nd2.validNumber(obj.index);
        this.getAreaInSquareMeters();
        this.changeTotalValueInPennyShow();
      },
      changeValueInArray(array, attributes = [], changeTo = 1, changeFrom = '') {
        for(let i in array){
          for(let a in attributes) {
            let checking = array[i][attributes[a]];
            if (checking === changeFrom){array[i][attributes[a]] = changeTo}
          }
        }
        return array;
      },
      cutValuesFromArray(array, attributes = [], cutValue = '') {
        for(let i in array){
          for(let a in attributes) {
            let checking = array[i][attributes[a]];
            if (checking === cutValue){array.splice(i, 1);}
          }
        }
        return array;
      },

    //End of methods
    },
  }
</script>
