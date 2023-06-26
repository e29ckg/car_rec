Vue.createApp({
    data() {
      return {
            q:'',
            datas: '',
            car_rec: {
                'book_number' : '',
                'book_year' : '',
                'req_date' : '',
                'user_req_id' : '',
                'location_name' : '',
                'why' : '',
                'followers_num' : '',
                'use_begin' : '',
                'use_end' : '',
                'status' : '',
                'comment' : '',
                'own_created' : 'test',
                'car_id' : '',
                'driver_id' : '',
                'act' : 'insert'
            },
            user_reqs : [],
            cars : [],
            drivers : [],
            
            isLoading : false,
        }
    },
    mounted(){
        this.get_car_recs()
    },
    watch: {
        q(){
            this.search()
        }
      },
    
    methods: {
        get_car_recs(){
            this.isLoading = true;
            axios.post('./api/index/get_car_recs.php')
            .then(response => {
                if (response.data.status) {
                    this.datas = response.data.data
                    // console.log(response.data)
                } 
            })
            .catch(function (error) {
                console.log(error);
            })
            .finally(() => {
                this.isLoading = false;
            })
        }, 
        get_cars(){
            this.isLoading = true;
            axios.post('./api/index/get_cars.php')
            .then(response => {
                this.cars = response.data.data
            })
            .catch(function (error) {
                console.log(error);
            })
            .finally(() => {
                this.isLoading = false;
            })
        }, 
        get_drivers(){
            this.isLoading = true;
            axios.post('./api/index/get_drivers.php')
            .then(response => {
                this.drivers = response.data.data
            })
            .catch(function (error) {
                console.log(error);
            })
            .finally(() => {
                this.isLoading = false;
            })
        }, 
       
        search(){
                if(this.q.length > 1 ){
                    this.isLoading = true
                    axios.post('./api/index/get_car_recs.php',{q:this.q})
                    .then(response => {
                        if (response.data.status) {
                            this.datas = response.data                        
                            this.projects = response.data.projects                        
                        } else{
                            this.projects = [
                                
                            ]
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .finally(() => {
                        this.isLoading = false;
                    })
                }else{
                    this.get_car_recs()
                }
        },
        car_rec_add(){
            this.car_rec.act = 'insert'
            this.get_cars()
            this.get_drivers()
            this.$refs.car_rec_form.click()  
        },

       print(id){
        this.isLoading = true
        axios.post('./api/cert/print.php',{id:id})    
            .then(response => {
                if (response.data.status) {
                    axios.post('./service/mpdf/api/cert/index.php',{
                        data        : response.data.resp,
                        template    : response.data.template,
                        text        : response.data.text[0],
                    }) 
                    .then(response => {
                        url = response.data.url
                        console.log(url)
                        window.open(url,'_blank')
                    })
                }else{
                  this.alert('warning',response.data.message,0)
                } 
            })
            .catch(function (error) {
                console.log(error);
            })
            .finally(() => {
                this.isLoading = false;
            })
  
      }, 
      add_users(id){
        axios.post('./api/cert/add_users.php',{project_id:id})    
            .then(response => {
                // this.alert(icon,message,timer=0)
                this.get_projects()
            })
            .catch(function (error) {
                console.log(error);
            });
      },
      del_user(id){
        axios.post('./api/cert/del_user.php',{id:id})    
            .then(response => {
                // this.alert(icon,message,timer=0)
                this.get_projects()
            })
            .catch(function (error) {
                console.log(error);
            });
      },


     
    //   alert(icon,message,timer=0){
    //     swal.fire({
    //       icon: icon,
    //       title: message,
    //       showConfirmButton: false,
    //       timer: timer
    //     });
    //   },
    },
  
  }).mount('#index')

  