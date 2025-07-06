
<!-- Download Report Modal -->
<div class="modal fade" id="downloadReportModal" tabindex="-1" aria-labelledby="downloadReportModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
   <form id="downloadReportForm" class="modal-content">
  @csrf
  <div class="modal-header">
    <h5 class="modal-title" id="downloadReportModalLabel">Download Report</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <div class="modal-body">
    <div class="mb-3">
      <label for="receipt_id" class="form-label">Enter Receipt Number</label>
      <input type="text" class="form-control" name="receipt_id" id="receipt_id" required
       style="border: 2px solid #0d6efd; border-radius: 4px;">
      <div id="downloadError" class="text-danger mt-2" style="display: none;"></div>
<div id="downloadSuccess" class="text-success mt-2" style="display: none;"></div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">Download</button>
  </div>
</form>

  </div>
</div>


<!-- Appointment Modal -->
<div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="appointmentForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Book Appointment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="mb-3">
              <label for="name" class="form-label">Patient Name</label>
              <input type="text" class="form-control" name="name" id="name" required style="border: 2px solid #0d6efd; border-radius: 4px;">
          </div>
          <div class="mb-3">
              <label for="age" class="form-label">Age</label>
              <input type="number" class="form-control" name="age" id="age" required style="border: 2px solid #0d6efd; border-radius: 4px;">
          </div>
          <div class="mb-3">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" name="address" id="address" required style="border: 2px solid #0d6efd; border-radius: 4px;">
          </div>
          <div class="mb-3">
              <label for="phone" class="form-label">Mobile</label>
              <input type="text" class="form-control" name="phone" id="phone" required style="border: 2px solid #0d6efd; border-radius: 4px;">
          </div>
          <div class="mb-3">
              <label for="doctor_id" class="form-label">Select Doctor</label>
               <select id="doctor_id" name="doctor_id" class="w-full border px-3 py-2 rounded" required>
                    <option value="">-- Choose --</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}"
                                data-name="{{ $doctor->name }}"
                                data-apdate="{{ $doctor->available_on }}">
                            Dr. {{ $doctor->name }} (ID: {{ $doctor->id }})
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="doctor_name" id="doctor_name">
                <input type="hidden" name="appointment_date" id="doctor_apdate-hidden">
          </div>
          <div id="appointmentSuccess" class="text-success mt-2" style="display: none;"></div>
          <div id="appointmentError" class="text-danger mt-2" style="display: none;"></div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Book Appointment</button>
      </div>
    </form>
  </div>
</div>

<!-- JavaScript -->
<script>
document.getElementById('appointmentForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = e.target;
    const successDiv = document.getElementById('appointmentSuccess');
    const errorDiv = document.getElementById('appointmentError');

    // Reset messages
    successDiv.style.display = 'none';
    errorDiv.style.display = 'none';
    successDiv.textContent = '';
    errorDiv.textContent = '';

    // Get selected doctor option
    const doctorSelect = document.getElementById('doctor_id');
    const selectedOption = doctorSelect.options[doctorSelect.selectedIndex];

    // Set hidden inputs with doctor data
    document.getElementById('doctor_name').value = selectedOption.getAttribute('data-name') || '';
    document.getElementById('doctor_apdate-hidden').value = selectedOption.getAttribute('data-apdate') || '';

    // 🔄 Create FormData after hidden inputs are set
    const formData = new FormData(form);

    fetch("{{ route('appointments.store') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { throw err; });
        }
        return response.json();
    })
    .then(data => {
        successDiv.style.display = 'block';
        successDiv.textContent = data.message || 'Appointment booked successfully!';
        form.reset();
    })
    .catch(error => {
        errorDiv.style.display = 'block';
        if (error.errors) {
            const messages = Object.values(error.errors).flat();
            errorDiv.textContent = messages.join(', ');
        } else {
            errorDiv.textContent = error.message || 'Failed to book appointment.';
        }
    });
});
</script>


<script>
document.getElementById('downloadReportForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const receiptId = document.getElementById('receipt_id').value;
    const errorDiv = document.getElementById('downloadError');
    const successDiv = document.getElementById('downloadSuccess');

    // Reset messages
    errorDiv.style.display = 'none';
    errorDiv.textContent = '';
    successDiv.style.display = 'none';
    successDiv.textContent = '';

    fetch(`/report/download?receipt_id=${encodeURIComponent(receiptId)}`, {
        method: 'GET',
    })
    .then(response => {
        if (response.status === 200) {
            return response.blob();
        } else {
            return response.text().then(text => {
                throw new Error(text);
            });
        }
    })
    .then(blob => {
        const downloadUrl = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = downloadUrl;
        a.download = "report.pdf";
        document.body.appendChild(a);
        a.click();
        a.remove();
        URL.revokeObjectURL(downloadUrl);

        // Show success message
        successDiv.style.display = 'block';
        successDiv.textContent = 'Report downloaded successfully.';
    })
    .catch(error => {
        errorDiv.style.display = 'block';
        errorDiv.textContent = 'Report not found or file missing.';
    });
});
</script>



</main>

<!-- Footer -->
<footer class="site-footer style-2 footer-dark background-blend-luminosity pt-4"
    style="background-image: url(images/background/bg1.webp)">



    

    <!-- Footer Top -->
    <div class="footer-middle">
        <div class="container">
            <div class="fm-inner">
                <div class="row g-3 align-items-center">
                    <div class="col-xl-3 col-md-12 col-sm-6 wow fadeInUp" data-wow-delay="0.2s"
                        data-wow-duration="0.8s">
                        <h3 class="title">Get in Touch with us</h3>
                        <p class="text">feel free to contact us anytime</p>
                    </div>
                    <div class="col-xl-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.4s" data-wow-duration="0.8s">
                        <div class="icon-bx-wraper style-1">
                            <div class="icon-bx bg-primary">
                                <span class="icon-cell">
                                    <i class="feather icon-phone"></i>
                                </span>
                            </div>
                            <div class="icon-content">
                                <h5 class="dz-title">Call Us</h5>
                                <p><a href="tel:+918100644924" class="text-body">+91 8100644924</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.6s" data-wow-duration="0.8s">
                        <div class="icon-bx-wraper style-1">
                            <div class="icon-bx bg-primary">
                                <span class="icon-cell">
                                    <i class="feather icon-mail"></i>
                                </span>
                            </div>
                            <div class="icon-content">
                                <h5 class="dz-title">Send us a Mail</h5>
                                <p><a href="mailto:doctorghoshsclinic@gmail.com" class="text-body">doctorghoshsclinic@gmail.com</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.8s" data-wow-duration="0.8s">
                        <div class="icon-bx-wraper style-1">
                            <div class="icon-bx bg-primary">
                                <span class="icon-cell">
                                    <i class="feather icon-clock"></i>
                                </span>
                            </div>
                            <div class="icon-content">
                                <h5 class="dz-title">Opening Time</h5>
                                <p>Mon -Sat: 7:00 - 17:00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="fb-inner">
                <div class="row">
                    <div class="col-lg-6 col-md-12 text-start">
                        <p class="copyright-text">© <span class="current-year">2024</span> All Rights Reserved.
                        </p>
                    </div>
                    <div class="col-lg-6 col-md-12 text-end">
                        <img src="images/card.webp" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Bottom End -->

</footer>
<!-- Footer End -->

<button class="scroltop" type="button"><i class="fas fa-arrow-up"></i></button>

</div>
<!-- JAVASCRIPT FILES ========================================= -->
<script src="../assets/js/global.min.js"></script>
<script src="../assets/vendor/popper/popper.js"></script>
<script src="../assets/vendor/tempus-dominus/js/tempus-dominus.min.js"></script>
<script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="../assets/vendor/imagesloaded/imagesloaded.js"></script>
<script src="../assets/vendor/masonry/isotope.pkgd.min.js"></script>
<script src="../assets/vendor/twentytwenty/js/jquery.event.move.js"></script>
<script src="../assets/vendor/twentytwenty/js/jquery.twentytwenty.js"></script>
<script src="../assets/vendor/wnumb/wNumb.js"></script>
<script src="../assets/vendor/countdown/jquery.countdown.js"></script>
<script src="../assets/js/dz.carousel.js"></script>
<script src="../assets/js/dz.ajax.js"></script>
<script src="../assets/js/custom.js"></script>
</body>

</html>