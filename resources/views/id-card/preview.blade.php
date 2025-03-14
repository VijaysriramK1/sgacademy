<div
    x-data="{
        role: $wire.entangle('data.role_id').live,
        studentId: $wire.entangle('data.student_id').live,
        profile_layout: $wire.entangle('data.profile_layout').live,
        logo: $wire.entangle('data.logo').live,
        profileImage: $wire.entangle('data.profileImage').live,
        width: $wire.entangle('data.pageLayoutWidth').live,
        height: $wire.entangle('data.pageLayoutHeight').live,
        layout: $wire.entangle('data.layout').live || 'horizontal',
        backgroundImage: $wire.entangle('data.background_image').live,
        
    
        fields: {
            'Admission No': $wire.entangle('data.student.admission_no').live,
            'Name': $wire.entangle('data.student.first_name').live,
            'Class': $wire.entangle('data.student.program.name').live,
            'Father Name': $wire.entangle('data.student.parent.father_name').live,
            'Mother Name': $wire.entangle('data.student.parent.mother_name').live,
            'Address': $wire.entangle('data.student.address').live,
            'Phone': $wire.entangle('data.student.phone').live,
            'Date of Birth': $wire.entangle('data.student.date_of_birth').live,
            'Blood Group': $wire.entangle('data.student.blood_group').live
        },
        
      
        visibleFields: {
            'Admission No': $wire.entangle('data.admission_no').live,
            'Name': $wire.entangle('data.student_name').live,
            'Class': $wire.entangle('data.program').live,
            'Father Name': $wire.entangle('data.father_name').live,
            'Mother Name': $wire.entangle('data.mother_name').live,
            'Address': $wire.entangle('data.student_address').live,
            'Phone': $wire.entangle('data.phone_number').live,
            'Date of Birth': $wire.entangle('data.dob').live,
            'Blood Group': $wire.entangle('data.blood').live
        },
        
        getLayoutStyles() {
            const layouts = {
                horizontal: {
                    backgroundImage: this.background_image 
                        ? `url(${this.background_image[0]})` 
                        : 'url(https://sgacademy.betelgeusetech.com/public/backEnd/id_card/img/horizontal_bg.png)',
                    width: this.width ? `${this.width}mm` : '86mm',
                    height: this.height ? `${this.height}mm` : '54mm',
                    flexDirection: 'row'
                },
                vertical: {
                    backgroundImage: this.background_image 
                        ? `url(${this.background_image[0]})` 
                        : 'url(https://sgacademy.betelgeusetech.com/public/backEnd/id_card/img/vertical_bg.png)',
                    width: this.width ? `${this.width}mm` : '57.15mm',
                    height: this.height ? `${this.height}mm` : '88.9mm',
                    flexDirection: 'column'
                }
            };
            return layouts[this.layout] || layouts.horizontal;
        }
    }"
    class="id-card-preview"
    :class="layout === 'horizontal' ? 'flex' : 'block'"
    :style="`
        line-height: 1.02;
        background-image: ${getLayoutStyles().backgroundImage};
        width: ${getLayoutStyles().width};
        height: ${getLayoutStyles().height};
        margin: auto;
        background-size: 100% 100%;
        background-position: center center;
        position: relative;
        flex-direction: ${getLayoutStyles().flexDirection};
        background-color: #fff;
        transition: all 0.3s ease;
    `">
    <!-- Left/Top Section -->
    <div
        class="card-left-section"
        :style="`
        ${layout === 'horizontal' ? 'width: 40%; margin-right: 10px;' : 'width: 100%; text-align: center;'}
    `">
        <!-- Logo Preview -->
        <div
            x-show="logo"
            class="logo-preview"
            :style="`text-align: ${layout === 'horizontal' ? 'left' : 'center'};`">
            <img
                x-bind:src="logo && logo.length > 0 
            ? logo[0] 
            : 'https://sgacademy.betelgeusetech.com/public/uploads/settings/logo.png'"
                alt="Logo"
                style="
            max-width: 80px;
            height: auto;
            margin-bottom: 10px;
            object-fit: contain;
            margin-top: 16px;
            margin-left: 9px;
        ">
        </div>

        <!-- Profile Image Container -->
        <div
            class="profile-image-container"
            :style="`
            text-align: center;
            display: flex;
            justify-content: ${layout === 'horizontal' ? 'flex-start' : 'center'};
            width: 100%;
            margin-top: 40px;
        `">
            <img
                x-bind:src="profileImage && profileImage.length > 0 
                ? profileImage[0] 
                : 'https://sgacademy.betelgeusetech.com/public/uploads/staff/demo/staff.jpg'"
                alt="Profile"
                :style="`
                width: 21mm;
                height: 21mm;
                border-radius: ${profile_layout === 'circle' ? '50%' : '0%'};
                object-fit: cover;
                margin: 0 ${layout === 'horizontal' ? '0' : 'auto'};
            `">
        </div>
    </div>

    <!-- Right/Bottom Section -->
    <div
        class="card-right-section"
        :style="`
          margin-top:${layout === 'horizontal' ? '45px' : '0.2rem'};
          margin-left: ${layout === 'horizontal' ? '-30px' : 'auto'};
            ${layout === 'horizontal' ? 'width: 60%; display: flex; flex-direction: column;' : 'width: 100%; text-align: center;'}
        `">
        <ul style="list-style-type: none; padding: 0; margin-top: 10px;">
            <template x-for="(value, key) in fields" :key="key">
                <li
                    x-show="visibleFields[key] === 1 || visibleFields[key] === true"
                    :style="`
                        padding: 2px 0;
                        text-align: ${layout === 'horizontal' ? 'left' : 'left'};
                        color: black;
                        font-size: ${layout === 'horizontal' ? '0.7rem' : '0.7rem'};
                        font-weight: 600;
                        margin-left: ${layout === 'horizontal' ? '0.8rem' : '0.7rem'};
                    `">
                    <span x-text="key + ': '"></span>
                    <span x-text="value || '---'" style="font-weight: 500;"></span>
                </li>
            </template>
        </ul>
    </div>

    <!-- Signature Section -->
    <div style="position: absolute; bottom: 5px; right: 5px; font-size: 8px;">
        <img
            x-bind:src="logo && logo.length > 0 
            ? logo[0] 
            : 'https://sgacademy.betelgeusetech.com/public/backEnd/id_card/img/Signature.png'"
            alt="Logo"
            style="
            max-width: 70px;
            height: auto;
            object-fit: contain;
            margin-top: 16px;
            margin-left: 9px;
        ">
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('idCardPreview', () => ({
            init() {
                console.log('ID Card Preview Initialized');
            }
        }))
    })
</script>
@endpush