
import { combineReducers } from 'redux';
import getAllServices from './getAllServices';
import getAllArea from './getAllArea';
import AddService from './AddService';
import RemoveService from './RemoveService';
import applicationData from './applicationData';

const allReducer = combineReducers({
     getAllServices : getAllServices,
     getAllArea : getAllArea,
     AddService : AddService,
     RemoveService : RemoveService,
     applicationData : applicationData
})

export default allReducer;