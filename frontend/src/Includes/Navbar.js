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
                                    Upload Font
                                </Link>
                            </li>
                            <li>
                                <Link to="/">
                                    Create Font Group
                                </Link>
                            </li>
                            <li>
                                <Link to="/">
                                    All Font Group
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Navbar;