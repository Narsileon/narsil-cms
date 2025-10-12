import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type CardTitleProps = ComponentProps<"div">;

function CardTitle({ className, ...props }: CardTitleProps) {
  return (
    <div
      data-slot="card-title"
      className={cn("font-semibold leading-none", className)}
      {...props}
    />
  );
}

export default CardTitle;
