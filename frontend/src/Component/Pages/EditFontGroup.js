import Navbar from "../../Includes/Navbar"
import { useParams, useHistory } from "react-router";
import { useEffect, useState } from "react";

const EditFontGroup = (props) => {

    const history = useHistory();
    const [fontGroupData, setfontGroupData] = useState({});
    const [fontGroupName, setFontGroupName] = useState("");

    //FETCH ALL FONT
    const getFonts = () => {
        const get_fonts_url = `${window.url}?dispatch=Font.index`;
        fetch(get_fonts_url, {
            method: "GET",

        })
            .then(response => response.json())
            .then(response => {
                if (response.status === true) {
                    setFonts(response.data);
                }
            })
            .catch(error => {
                console.log(error);
            });
    };
    const [fonts, setFonts] = useState([]);
    //FETCH ALL FONT


    //DYNAMIC FORM
    const [rows, setRows] = useState([{ id: 1, fontName: '', fontType: '', specificSize: '', priceChange: '' }]);

    const appendRow = () => {
        setRows([
            ...rows,
            { id: rows.length + 1, fontName: '', fontType: '', specificSize: '', priceChange: '' }
        ]);
    };

    const removeRow = (index) => {
        const updatedRows = rows.filter((row, i) => i !== index);
        setRows(updatedRows);
    };

    const updateRow = (index, field, value) => {

        if ((field === 'specificSize' || field === 'priceChange') && value < 0) {
            alert(`${field} cannot be less than 0`);
            return;
        }

        const updatedRows = rows.map((row, i) =>
            i === index ? { ...row, [field]: value } : row
        );
        setRows(updatedRows);
    };
    //DYNAMIC FORM


    //CREATE FONT GROUP
    function updateFontGroup() {
        if (rows.length <= 0) {
            alert("Please add atleast one row")
            return;
        }

        if (window.confirm("Are you sure you want to update font group?")) {
            if (!fontGroupName) {
                alert("Please enter the font group name")
                return;
            }

            const fontNames = fonts.map(font => font.name);

            const emptyKeys = new Set(); // Use a Set to avoid duplicate keys

            rows.forEach(value => {
                Object.entries(value).forEach(([index, data]) => {
                    if (data === '' || data === null || data === undefined) {
                        emptyKeys.add(index); // Add the key to the Set
                    }
                });
            });

            if (emptyKeys.size > 0) {
                alert(`The following fields have empty values: ${[...emptyKeys].join(', ')}`);
                return;
            }

            const formData = new FormData();
            formData.append("groupName", fontGroupName);
            formData.append("rowData", JSON.stringify(rows));
            formData.append("id",id)

            const update_font_group_url = `${window.url}?dispatch=FontGroup.update`;
            const options = {
                method: "POST",
                body: formData
            };

            fetch(update_font_group_url, options)
                .then(response => response.json())
                .then(response => {
                    alert(response.message)
                    if (response.status == true) {
                        history.push("/fontGroup")
                    }
                })
                .catch(response => {
                    console.log(response)
                })

        }
    }
    //CREATE FONT GROUP


    const { id } = useParams();
    const getFontGroupByIdUrl = `${window.url}?dispatch=FontGroup.edit&font_group_id=${id}`;
    useEffect(() => {

        fetch(getFontGroupByIdUrl, {
            method: "GET"
        })
        .then(response => response.json())
        .then(response => {
            if(response.status){
                setfontGroupData(response.data);
                setFontGroupName(response.data.font_group_name);

                const formattedRows = response.data.font_group_data.map((item, index) => ({
                    id: index + 1,
                    fontName: item.font_name,
                    fontType: item.font_id,
                    specificSize: item.specific_size,
                    priceChange: item.price_change
                }));
    
                // Set the mapped data into the rows state
                setRows(formattedRows);
            }
            else{
                history.push("/fontGroup")
            }
        })
        .catch(response => {
            console.log(response)

        })


        getFonts()

    }, [getFontGroupByIdUrl]);

    return (
        <div className="id">
            <Navbar></Navbar>

            {/* create font group */}
            <section className="font-group">
                <div className="container">

                    <div className="row font-group-row">

                        <div className="col-md-6 col-6">
                            <p>Edit Font Group <strong>{fontGroupName && fontGroupName}</strong></p>
                        </div>

                        {/* submit button */}
                        <div className="col-md-6 col-6 form-group text-right">
                            <button type="button" className="btn btn-sm btn-info" onClick={updateFontGroup}>
                                Update
                            </button>
                        </div>

                        {/* group name */}
                        <div className="col-md-12 form-group">
                            <label>Group Name</label>
                            <input type="text" onInput={(e) => setFontGroupName(e.target.value)} value={fontGroupName && fontGroupName} className="form-control"></input>
                        </div>

                        {/* add row */}
                        <div className="col-md-12 form-group">
                            <button type="button" className="btn btn-sm btn-success" onClick={appendRow}>
                                +
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
                                    <div className="col-md-4">
                                        <select
                                            className="form-control"
                                            value={row.fontType}
                                            onChange={(e) => updateRow(index, 'fontType', e.target.value)}
                                        >
                                            <option value="" disabled>Select Font</option>
                                            {fonts.map((font) => (
                                                <option key={font.id} value={font.id}>
                                                    {font.name}
                                                </option>
                                            ))}
                                            {/* Add more options as needed */}
                                        </select>
                                    </div>

                                    {/* Specific Size Input */}
                                    <div className="col-md-2">
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
                                    <div className="col-md-2">
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
                                    <div className="col-md-1 text-right d-block">
                                        <button
                                            type="button"
                                            className="btn btn-sm btn-danger remove-row"
                                            onClick={() => removeRow(index)}
                                        >
                                            X
                                        </button>
                                    </div>
                                </div>
                            ))}


                        </div>


                    </div>

                </div>
            </section>
            {/* create font group */}
        </div>
    );
}

export default EditFontGroup;