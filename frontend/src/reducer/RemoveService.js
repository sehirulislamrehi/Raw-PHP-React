

const RemoveService = (state = false, action) => {
     if( action.type == "RemoveService" ){
          const res = action.response
          
          let services = JSON.parse(localStorage.getItem("services")) || [];

          services.filter((value, index) => {
               if (value.id == res.id) {
                    services.splice(index, 1);
                    localStorage.setItem("services", JSON.stringify(services));
               }
               
          });

          return services;

     }
     else{
          return state;
     }
}

export default RemoveService;