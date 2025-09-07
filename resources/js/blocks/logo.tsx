import { cn } from "@narsil-cms/lib/utils";
import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import React from "react";

type LogoProps = Omit<React.ComponentProps<typeof Link>, "href">;

function Logo({ className, ...props }: LogoProps) {
  return (
    <Link
      className={cn("text-xl font-bold", className)}
      href={route("dashboard")}
      {...props}
    >
      NARSIL
    </Link>
  );
}

export default Logo;
