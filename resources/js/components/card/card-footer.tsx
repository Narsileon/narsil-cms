import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type CardFooterProps = ComponentProps<"div">;

function CardFooter({ className, ...props }: CardFooterProps) {
  return (
    <div
      data-slot="card-footer"
      className={cn("flex items-center px-4 pb-4 [.border-t]:pt-4", className)}
      {...props}
    />
  );
}

export default CardFooter;
