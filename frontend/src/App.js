import { Route, BrowserRouter as Router, Switch } from "react-router-dom";

import AllFont from "./Component/Pages/AllFont";
import FontGroupComponent from "./Component/Pages/FontGroup";
import EditFontGroup from "./Component/Pages/EditFontGroup";

function App() {

  return (

    <Router>
      <Switch>

            {/* Home Component */}
            <Route exact path="/">
              <AllFont></AllFont>
            </Route>

            {/* Home Component */}
            <Route exact path="/fontGroup">
              <FontGroupComponent></FontGroupComponent>
            </Route>

            {/* EditFontGroup Component */}
            <Route path="/editFontGroup/:id">
              <EditFontGroup></EditFontGroup>
            </Route>

      </Switch>
    </Router>
    
    
  );
}

export default App;
