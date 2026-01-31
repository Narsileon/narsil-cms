import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function CardTitle({ className, ...props }: ComponentProps<"div">) {
  return (
    <div
      data-slot="card-title"
      className={cn("leading-none font-semibold", className)}
      {...props}
    />
  );
}

export default CardTitle;
