
let serviceSample = {
     id : "",
     name : "",
     slug : "",
     instruction : "",
     instructions_id : "",
     price : ""
}

const AddService = (state = false, action) => {
     if( action.type == "AddService" ){

          const res = action.response

          let services = JSON.parse(localStorage.getItem("services")) || [];
          let exist = false;

          serviceSample.id = res.id
          serviceSample.name = res.name
          serviceSample.slug = res.slug
          serviceSample.price = res.price
          serviceSample.instruction = res.instructions ? res.instructions : null 
          serviceSample.instructions_id = res.instructions_id ? res.instructions_id : null 

          services.filter((value, index) => {
               if( exist == false ){
                    if (value.id == serviceSample.id) {
                         exist = true;
                    }
               }
          });

          if (exist == false) {
               services.push(serviceSample);
          }

          localStorage.setItem("services", JSON.stringify(services));


          return action.response;
     }
     else{
          return state;
     }
}

export default AddService;