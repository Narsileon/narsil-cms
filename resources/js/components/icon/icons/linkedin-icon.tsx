import { type ComponentProps } from "react";

function LinkedinIcon({ ...props }: ComponentProps<"svg">) {
  return (
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="21.02"
      height="21"
      viewBox="0 0 21.02 21"
      fill="currentColor"
      {...props}
    >
      <path d="M2.52,5.07c-1.39,0-2.52-1.15-2.52-2.55C0,1.62.48.79,1.26.34,2.04-.11,3-.11,3.78.34c.78.45,1.26,1.28,1.26,2.18,0,1.39-1.13,2.55-2.52,2.55ZM4.7,21H.35V6.98h4.35v14.02ZM21,21h-4.34v-6.83c0-1.63-.03-3.71-2.26-3.71s-2.61,1.77-2.61,3.6v6.94h-4.35V6.98h4.18v1.91h.06c.58-1.1,2-2.26,4.12-2.26,4.41,0,5.22,2.9,5.22,6.67v7.7h-.02Z" />
    </svg>
  );
}

export default LinkedinIcon;
