import { cn } from "@/lib/utils";
import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import React from "react";

type AppLogo = Omit<React.ComponentProps<typeof Link>, "href">;

function AppLogo({ className, ...props }: AppLogo) {
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
