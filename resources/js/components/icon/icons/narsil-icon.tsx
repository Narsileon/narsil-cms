import { type ComponentProps } from "react";

function NarsilIcon({ ...props }: ComponentProps<"svg">) {
  return (
    <svg
      xmlns="http://www.w3.org/2000/svg"
      fill="currentColor"
      viewBox="0 0 384 512"
      className="size-5"
      {...props}
    >
      <path d="M21 34c13-5 27-1 36 9l263 317V64a32 32 0 1 1 64 0v384a32 32 0 0 1-57 21L64 152v296a32 32 0 1 1-64 0V64c0-13 8-25 21-30" />
    </svg>
  );
}

export default NarsilIcon;
