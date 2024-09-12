import { Route, BrowserRouter as Router, Switch } from "react-router-dom";

import HomeComponent from './Component/Pages/HomeComponent';
import AllFont from "./Component/Pages/AllFont";

function App() {

  return (

    <Router>
      <Switch>

            {/* Home Component */}
            <Route exact path="/">
              <HomeComponent ></HomeComponent>
            </Route>

      </Switch>
    </Router>
    
    
  );
}

export default App;
