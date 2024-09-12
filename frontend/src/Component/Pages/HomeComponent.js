
import { useHistory } from "react-router-dom";
import { useEffect, useState } from "react";
import Navbar from "../../Includes/Navbar"

const HomeComponent = (props) => {

     {/* window scroll to top */ }
     // window.scrollTo(0, 0);

     const history = useHistory();

     const getFonts = () => {
          const get_fonts_url = `${window.url}?dispatch=Font.index`;
          fetch(get_fonts_url, {
               method: "GET",

          })
               .then(response => response.json())
               .then(response => {
                    if (response.status === true) {
                         setFonts(response.data);

                         const style = document.createElement('style');

                         response.data.forEach(font => {
                              style.textContent += `
                          @font-face {
                              font-family: '${font.name}';
                              src: url('${window.image_path}${font.path}') format('truetype');
                          }
                      `;
                         });

                         document.head.appendChild(style);
                    }
               })
               .catch(error => {
                    console.log(error);
               });
     };

     function uploadFile(e) {
          const file = e.target.files[0]

          const formData = new FormData();
          formData.append("image", e.target.files[0]);

          const update_profile_url = `${window.url}?dispatch=Font.create`;
          const options = {
               method: "POST",
               body: formData
          };

          fetch(update_profile_url, options)
               .then(response => response.json())
               .then(response => {
                    alert(response.message)
                    if (response.status == true) {
                         // history.push("/all-font")
                         getFonts();
                    }
               })
               .catch(response => {
                    console.log(response)
               })
     }

     const [fonts, setFonts] = useState([]);

     useEffect(() => {
          getFonts();

     }, []);

     function deleteFont(font_id) {

          if (window.confirm("Are you sure you want to remove the font?")) {
               const formData = new FormData();
               formData.append("font_id", font_id);

               const delete_font_url = `${window.url}?dispatch=Font.delete`;
               const options = {
                    method: "POST",
                    body: formData
               };

               fetch(delete_font_url, options)
                    .then(response => response.json())
                    .then(response => {
                         alert(response.message)
                         if (response.status == true) {
                              // history.push("/all-font")
                              getFonts();
                         }
                    })
                    .catch(response => {
                         console.log(response)
                    })
          }

     }


     return (
          <div className="id">
               <Navbar></Navbar>

               <section className="section-title">
                    <div className="container">
                         <div className="row">
                              <div className="col-md-12">
                                   <h2>Manage Fonts</h2>
                              </div>
                         </div>
                    </div>
               </section>

               <section className="file-uploader">
                    <div className="container">

                         <div className="row">

                              {/* image */}
                              <div className="col-md-12">
                                   <label>Upload .ttf file</label> <br></br>
                                   <input type="file" className="form-control-file" onChange={uploadFile} accept=".ttf" ></input>
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
                                        <tbody>
                                             {fonts.map((font, index) => (
                                                  <tr key={font.id}>
                                                       <td>{index + 1}</td>
                                                       <td>{font.name}</td>
                                                       <td>
                                                            <p style={{ fontFamily: font.name }}>Example style</p>
                                                       </td>
                                                       <td>
                                                            <button onClick={() => deleteFont(font.id)}>Delete</button>
                                                       </td>
                                                  </tr>
                                             ))}
                                        </tbody>
                                   </table>
                              </div>
                         </div>
                    </div>
               </section>
          </div>
     );
}

export default HomeComponent;