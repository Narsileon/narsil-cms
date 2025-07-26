import { FormItem } from "@narsil-cms/components/ui/form";
import type { IconName } from "lucide-react/dynamic";

export type FieldType = {
  conditions?: FieldConditionType[] | null;
  description?: string;
  fields?: FieldType[];
  handle: string;
  icon?: IconName;
  id: number;
  name: string;
  settings?: Record<string, any>;
  visibility?: "display" | "display_when" | "hidden" | "hidden_when";
  width?: React.ComponentProps<typeof FormItem>["width"];
};

export type FieldConditionType = {
  operator: string;
  target_id: string;
  value: string;
};

export type FormType = {
  fields: FieldType[];
  id: string;
  method: string;
  submit: string;
  url: string;
};

export type SelectOption = {
  [key: string]: any;
  label: string;
  value: any;
} & {
  options?: SelectOption[]; // Grouped select options
};
