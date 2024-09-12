
import { useHistory } from "react-router-dom";
import { useEffect, useState } from "react";
import Navbar from "../../Includes/Navbar"

const FontGroupComponent = (props) => {

    {/* window scroll to top */ }
    // window.scrollTo(0, 0);

    const [rows, setRows] = useState([{ id: 1, fontName: '', fontType: 'Roboto', specificSize: '', priceChange: '' }]);

    const appendRow = () => {
        setRows([
            ...rows,
            { id: rows.length + 1, fontName: '', fontType: 'Roboto', specificSize: '', priceChange: '' }
        ]);
    };

    // Function to remove a row by index
    const removeRow = (index) => {
        const updatedRows = rows.filter((row, i) => i !== index);
        setRows(updatedRows);
    };

    const updateRow = (index, field, value) => {
        const updatedRows = rows.map((row, i) => 
            i === index ? { ...row, [field]: value } : row
        );
        setRows(updatedRows);
    };

    console.log(rows)

    return (
        <div className="id">
            <Navbar></Navbar>

            <section className="section-title">
                <div className="container">
                    <div className="row">
                        <div className="col-md-12">
                            <h2>Manage Font Groups</h2>
                        </div>
                    </div>
                </div>
            </section>

            <section className="font-group">
                <div className="container">

                    <div className="row font-group-row">

                        {/* group name */}
                        <div className="col-md-12 form-group">
                            <label>Group Name</label>
                            <input type="text" className="form-control"></input>
                        </div>

                        {/* add row */}
                        <div className="col-md-12 form-group">
                            <button type="button" className="btn btn-sm btn-success" onClick={appendRow}>
                                Add Row
                            </button>
                        </div>

                        {/* fonts container */}
                        <div className="col-md-12 form-group fonts-container">

                            {rows.map((row, index) => (
                                <div className="row fonts-row" key={row.id}>
                                    {/* Font Name Input */}
                                    <div className="col-md-3">
                                        <input
                                            type="text"
                                            className="form-control"
                                            placeholder="Font Name"
                                            value={row.fontName}
                                            onChange={(e) => updateRow(index, 'fontName', e.target.value)}
                                        />
                                    </div>

                                    {/* Font Type Select */}
                                    <div className="col-md-3">
                                        <select
                                            className="form-control"
                                            value={row.fontType}
                                            onChange={(e) => updateRow(index, 'fontType', e.target.value)}
                                        >
                                            <option value="Roboto">Roboto</option>
                                            <option value="Arial">Arial</option>
                                            <option value="Times New Roman">Times New Roman</option>
                                            {/* Add more options as needed */}
                                        </select>
                                    </div>

                                    {/* Specific Size Input */}
                                    <div className="col-md-3">
                                        <input
                                            type="number"
                                            step="0.01"
                                            className="form-control"
                                            placeholder="Specific Size"
                                            value={row.specificSize}
                                            onChange={(e) => updateRow(index, 'specificSize', e.target.value)}
                                        />
                                    </div>

                                    {/* Price Change Input */}
                                    <div className="col-md-3">
                                        <input
                                            type="number"
                                            step="0.01"
                                            className="form-control"
                                            placeholder="Price Change"
                                            value={row.priceChange}
                                            onChange={(e) => updateRow(index, 'priceChange', e.target.value)}
                                        />
                                    </div>

                                    {/* Remove Row Button */}
                                    <div className="col-md-12 text-right mt-3 d-block">
                                        <button
                                            type="button"
                                            className="btn btn-sm btn-danger"
                                            onClick={() => removeRow(index)}
                                        >
                                            Remove Row
                                        </button>
                                    </div>
                                </div>
                            ))}


                        </div>


                    </div>

                </div>
            </section>

            <section className="all-font-section">
                <div className="container">
                    <div className="row">
                        <div className="col-md-12">
                            <table className="table table-striped table-dark">
                                <thead>
                                    <tr>
                                        <th>SI</th>
                                        <th>Name</th>
                                        <th>Preview</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
}

export default FontGroupComponent;