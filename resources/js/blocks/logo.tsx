import { Link } from "@inertiajs/react";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";
import { route } from "ziggy-js";

type LogoProps = Omit<ComponentProps<typeof Link>, "href">;

function Logo({ className, ...props }: LogoProps) {
  return (
    <Link className={cn("text-xl font-bold", className)} href={route("dashboard")} {...props}>
      NARSIL
    </Link>
  );
}

export default Logo;
