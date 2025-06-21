import { cn } from "@/lib/utils";

export type CardTitleProps = React.ComponentProps<"div"> & {};

function CardTitle({ className, ...props }: CardTitleProps) {
  return (
    <div
      className={cn("leading-none font-semibold", className)}
      data-slot="card-title"
      {...props}
    />
  );
}

export default CardTitle;
