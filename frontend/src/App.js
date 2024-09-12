import { Route, BrowserRouter as Router, Switch } from "react-router-dom";

import HomeComponent from './Component/Pages/HomeComponent';
import AllFont from "./Component/Pages/AllFont";
import FontGroupComponent from "./Component/Pages/FontGroup";

function App() {

  return (

    <Router>
      <Switch>

            {/* Home Component */}
            <Route exact path="/">
              <HomeComponent ></HomeComponent>
            </Route>

            {/* Home Component */}
            <Route exact path="/fontGroup">
              <FontGroupComponent></FontGroupComponent>
            </Route>

      </Switch>
    </Router>
    
    
  );
}

export default App;
