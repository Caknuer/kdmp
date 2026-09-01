{{-- Batik decorative component: resources/views/components/batik.blade.php --}}
<div class="batik-decor" aria-hidden="true" style="--batik-accent:#F53003; --batik-accent-2:#FF4433; --batik-bg:#fff2f2;">
    <style>
        /* Centered and spread across page */
        .batik-decor{
            position:fixed;
            top:50%;
            left:50%;
            transform:translate(-50%, -50%);
            pointer-events:none;
            z-index:0;
            mix-blend-mode:multiply;
            width:100vw;
            height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
        }
        .batik-pattern{
            width:100%;
            height:100%;
            opacity:.08;
            display:block;
        }
        @media (max-width:1024px){.batik-pattern{opacity:.06}}
        @media (max-width:640px){.batik-pattern{opacity:.04}}
    </style>

    <svg class="batik-pattern" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true" preserveAspectRatio="xMidYMid slice">
        <defs>
            <pattern id="batikTile" width="40" height="40" patternUnits="userSpaceOnUse" patternTransform="rotate(0)">
                <rect width="40" height="40" fill="var(--batik-bg)" />
                <g fill="var(--batik-accent)">
                    <circle cx="10" cy="10" r="3" />
                    <circle cx="30" cy="30" r="3" />
                </g>
                <g fill="var(--batik-accent-2)">
                    <rect x="18" y="6" width="4" height="28" rx="1" />
                    <path d="M0 20 L6 14 L12 20 L6 26 Z" transform="translate(14,6)" />
                </g>
            </pattern>
        </defs>

        <rect width="100%" height="100%" fill="url(#batikTile)" />
    </svg>
</div>
