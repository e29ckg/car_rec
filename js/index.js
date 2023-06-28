Vue.createApp({
    data() {
      return {
            q:'',
            datas: '',
            car_recs: [],
            car_rec: {
                'book_number' : '',
                'book_year' : '',
                'req_date' : '',
                'user_req_id' : '',
                'location_name' : '',
                'why' : '',
                'followers_num' : '',
                'use_begin' : '',
                'use_begin_t' : '',
                'use_end' : '',
                'use_end_t' : '',
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
            users : [],
            boss : [],
            
            isLoading : false,
        }
    },
    mounted(){
        this.get_car_recs()
        this.get_boss()
        this.get_cars()
    },
    watch: {
        q(){
            this.search()
        }
      },
    
    methods: {
        get_boss(){
            this.isLoading = true;
            axios.post('http://10.37.64.1/api/car_rec/get_boss.php')
            .then(response => {
                if (response.data.status) {
                    this.boss = response.data.data
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
        get_car_recs(){
            this.isLoading = true;
            axios.post('./api/index/get_car_recs.php')
            .then(response => {
                this.car_recs = response.data.data
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
        get_users(){
            this.isLoading = true;
            axios.post('./api/index/get_users.php')
            .then(response => {
                this.users = response.data.data
            })
            .catch(function (error) {
                console.log(error);
            })
            .finally(() => {
                this.isLoading = false;
            })
        }, 
       
        // search(){
        //         if(this.q.length > 1 ){
        //             this.isLoading = true
        //             axios.post('./api/index/get_car_recs.php',{q:this.q})
        //             .then(response => {
        //                 if (response.data.status) {
        //                     this.datas = response.data                        
        //                     this.projects = response.data.projects                        
        //                 } else{
        //                     this.projects = [
                                
        //                     ]
        //                 }
        //             })
        //             .catch(function (error) {
        //                 console.log(error);
        //             })
        //             .finally(() => {
        //                 this.isLoading = false;
        //             })
        //         }else{
        //             this.get_car_recs()
        //         }
        // },
        car_rec_cls(){
            this.car_rec = {'book_number' : '', 'book_year' : '', 'req_date' : '', 'user_req_id' : '', 'location_name' : '',
                'why' : '', 'followers_num' : '', 'use_begin' : '', 'use_begin_t' : '', 'use_end' : '', 'use_end_t' : '',
                'status' : '', 'comment' : '', 'own_created' : 'test', 'car_id' : '', 'driver_id' : '', 'act' : 'insert'}
        },
        car_rec_add(){
            this.car_rec_cls()
            this.car_rec.act = 'insert'
            this.get_cars()
            this.get_drivers()
            this.get_users()
            this.$refs.car_rec_form.click()  
        },
        car_rec_update(index){
            this.car_rec = this.car_recs[index]
            this.car_rec.act = 'update'
            this.get_cars()
            this.get_drivers()
            this.get_users()
            this.$refs.car_rec_form.click()  
        },
        car_rec_save(){
            this.isLoading = true
            axios.post('./api/index/car_rec_act.php',{car_rec:this.car_rec})
            .then(response => {
                const resp = response.data 
                const icon = resp.status; // กำหนดไอคอนที่ต้องการแสดงใน alert
                const message = resp.message; // กำหนดข้อความที่ต้องการแสดงใน alert
                const timer = 1500; // กำหนดเวลาในการแสดง alert (0 = ไม่มีการปิดอัตโนมัติ)
                this.alert(icon, message, timer);
                if(resp.status == 'success'){
                    this.$refs.btn_car_rec_close.click() 
                    this.car_rec_cls()
                    this.get_car_recs()
                }
            })
            .catch(function (error) {
                console.log(error);
            })
            .finally(() => {
                this.isLoading = false;
            })
        
        },
        car_rec_delete(index){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.isConfirmed) {
                  this.isLoading = true;
                  this.car_rec = this.car_recs[index]
                  this.car_rec.act = 'delete' 
                  const requestData = { car_rec: this.car_rec};
                  axios
                    .post('./api/index/car_rec_act.php', requestData)
                    .then(response => {
                      const resp = response.data 
                      
                      const icon = resp.status; // กำหนดไอคอนที่ต้องการแสดงใน alert
                      const message = resp.message; // กำหนดข้อความที่ต้องการแสดงใน alert
                      const timer = 2000; // กำหนดเวลาในการแสดง alert (0 = ไม่มีการปิดอัตโนมัติ)
                      this.alert(icon, message, timer);                    
                      if(resp.status == 'success'){
      
                          this.get_car_recs()
                      }
                    })
                    .catch(error => {
                      console.log(error);
                    })
                    .finally(() => {
                      this.isLoading = false;
                    });
                }
              })
        },

       print(index){
        this.isLoading = true
        
        axios.post('./service/mpdf/api/car_rec/index.php',{
            data : this.car_recs[index],
            boss : this.boss[0],
            cars : this.cars,
        }) 
        .then(response => {
            url = response.data.url
            console.log(url)
            window.open(url,'_blank')
        })
        .catch(function (error) {
            console.log(error);
        })
        .finally(() => {
            this.isLoading = false;
        })
  
      }, 
      


     
      alert(icon,message,timer=0){
        swal.fire({
          icon: icon,
          title: message,
        //   showConfirmButton: false,
          timer: timer
        });
      },
    },
  
  }).mount('#index')

  