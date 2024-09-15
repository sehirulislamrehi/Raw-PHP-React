import { Link } from "react-router-dom";

const Navbar = () => {
    return (
        <div className="container">
            <div className="row">
                <div className="col-md-12">
                    <div className="mynav">
                        <ul>
                            <li>
                                <Link to="/">
                                    Manage Fonts
                                </Link>
                            </li>
                            {/* <li>
                                <Link to="/fontGroup">
                                    Manage Font Groups
                                </Link>
                            </li> */}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Navbar;