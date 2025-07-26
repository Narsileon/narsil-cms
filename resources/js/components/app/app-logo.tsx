import { cn } from "@narsil-cms/lib/utils";
import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import React from "react";

type AppLogoProps = Omit<React.ComponentProps<typeof Link>, "href">;

function AppLogo({ className, ...props }: AppLogoProps) {
  return (
    <Link
      className={cn("text-xl font-bold", className)}
      href={route("home")}
      {...props}
    >
      NARSIL
    </Link>
  );
}

export default AppLogo;
