import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function CardDescription({ className, ...props }: ComponentProps<"div">) {
  return (
    <div
      data-slot="card-description"
      className={cn("text-muted-foreground", className)}
      {...props}
    />
  );
}

export default CardDescription;
