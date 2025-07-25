export type Field = {
  conditions?: FieldCondition[] | null;
  description?: string;
  fields?: Field[];
  handle: string;
  id: number;
  name: string;
  settings?: Record<string, any>;
  visibility?: "display" | "display_when" | "hidden" | "hidden_when";
  width?: number;
};

export type FieldCondition = {
  operator: string;
  target_id: string;
  value: string;
};
