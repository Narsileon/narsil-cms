import { useLocalization } from "@narsil-cms/components/localization";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type FormTimestampProps = ComponentProps<"div"> & {
  date: string;
  label: string;
  name?: string;
};

function FormTimestamp({ className, date, label, name, ...props }: FormTimestampProps) {
  const { trans } = useLocalization();

  return (
    <div className={cn("flex items-center gap-1", className)} {...props}>
      <span className="text-muted-foreground">{label}</span>
      <span className="font-medium">{date}</span>
      {name ? (
        <>
          <span className="text-muted-foreground">{trans("datetime.by")}</span>
          <span className="font-medium">{name}</span>
        </>
      ) : null}
    </div>
  );
}

export default FormTimestamp;
