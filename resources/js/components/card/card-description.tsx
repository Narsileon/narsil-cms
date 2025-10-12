import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type CardDescriptionProps = ComponentProps<"div">;

function CardDescription({ className, ...props }: CardDescriptionProps) {
  return (
    <div
      data-slot="card-description"
      className={cn("text-muted-foreground", className)}
      {...props}
    />
  );
}

export default CardDescription;
