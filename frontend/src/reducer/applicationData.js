

const applicationData = (state = false, action) => {
     if( action.type == "applicationData" ){
          return action.response

     }
     else{
          return state;
     }
}

export default applicationData;