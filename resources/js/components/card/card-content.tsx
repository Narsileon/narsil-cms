import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function CardContent({ className, ...props }: ComponentProps<"div">) {
  return <div data-slot="card-content" className={cn("grid gap-4 p-4", className)} {...props} />;
}

export default CardContent;
