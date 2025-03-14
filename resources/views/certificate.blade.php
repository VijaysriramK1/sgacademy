@props(['certificate'])

@php
    $defaultImage = asset('storage/01JFMEZJT9QSDCF7JM5EZV5XF3.jpeg');
@endphp

<div
    x-data="{
        file: @entangle('data.file').live,
        defaultImage: '{{ $defaultImage }}',
        getBackgroundImage() {
            try {
                // For debugging - log the current file value
                console.log('Current file value:', this.file);
                
                // If file is empty/null, return default image
                if (!this.file) {
                    console.log('Using default image');
                    return `url('${this.defaultImage}')`;
                }
                
                // If file is an object (usually happens with fresh uploads)
                if (typeof this.file === 'object' && this.file !== null) {
                    console.log('File is an object:', this.file);
                    return `url('${this.defaultImage}')`;
                }
                
                // If file is a string but doesn't contain a full URL
                if (typeof this.file === 'string' && !this.file.includes('://')) {
                    console.log('Converting to full storage URL');
                    return `url('/storage/${this.file}')`;
                }
                
                // If file is already a complete URL
                console.log('Using complete URL');
                return `url('${this.file}')`;
            } catch (error) {
                console.error('Error in getBackgroundImage:', error);
                return `url('${this.defaultImage}')`;
            }
        }
    }"
    x-init="$watch('file', value => console.log('File changed:', value))"
    :style="{
        width: width ? `${width}px` : '550px',
        height: height ? `${height}px` : '100mm',
        fontFamily: bodyFontFamily,
        fontSize: bodyFontSize,
        display: 'flex',
        padding: '20px',
        boxSizing: 'border-box',
        justifyContent: 'space-between',
        backgroundImage: getBackgroundImage(),
        backgroundSize: 'cover',
        backgroundPosition: 'center',
        position: 'relative',
        border: '1px solid #ccc' // Added for visibility during debugging
    }"
>
    <!-- Debug output -->
    <div x-show="!getBackgroundImage().includes(defaultImage)" class="bg-red-100 p-2 absolute top-0 left-0">
        <small x-text="'Current image path: ' + file"></small>
    </div>

    <!-- Rest of your template content -->
</div>