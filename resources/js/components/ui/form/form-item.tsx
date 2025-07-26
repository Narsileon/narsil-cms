import { cn } from "@narsil-cms/lib/utils";
import { cva } from "class-variance-authority";
import type { VariantProps } from "class-variance-authority";

export const formItemVariants = cva(cn("flex flex-col gap-2 col-span-full"), {
  variants: {
    width: {
      25: "md:col-span-3",
      33: "md:col-span-4",
      50: "md:col-span-6",
      67: "md:col-span-8",
      75: "md:col-span-9",
      100: "md:col-span-12",
    },
  },
  defaultVariants: {
    width: 100,
  },
});

type FormItemProps = React.ComponentProps<"div"> &
  VariantProps<typeof formItemVariants> & {};

function FormItem({ className, width = 100, ...props }: FormItemProps) {
  return (
    <div
      data-slot="form-item"
      className={cn(
        formItemVariants({
          className: className,
          width: width,
        }),
      )}
      {...props}
    />
  );
}

export default FormItem;
